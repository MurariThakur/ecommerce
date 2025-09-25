<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Mail\OrderStatusUpdateMail;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems'])
            ->where('isdelete', false);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('email', 'like', "%{$search}%")
                            ->orWhere('name', 'like', "%{$search}%");
                    });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Payment status filter
        if ($request->filled('payment_status')) {
            $query->where('is_payment', $request->payment_status === 'paid');
        }

        // Date filters
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(10)->appends($request->query());

        return view('admin.order.index', compact('orders'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load([
            'user',
            'orderItems.product.category',
            'orderItems.product.subcategory',
            'orderItems.product.brand',
            'orderItems.product.productImages'
        ]);

        // Load shipping method name
        if ($order->shipping_method) {
            $shipping = \App\Models\Shipping::find($order->shipping_method);
            $order->shipping_method_name = $shipping ? $shipping->name : 'Unknown';
        }
        return view('admin.order.show', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled,return_requested,return_processing,return_approved,return_rejected,refunded'
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        // Validate status transitions
        if (!$this->isValidStatusTransition($oldStatus, $newStatus)) {
            return redirect()->route('admin.order.index')
                ->with('error', "Cannot change order status from '{$oldStatus}' to '{$newStatus}'.");
        }

        // Create refund record if cancelling a paid order
        if ($newStatus === 'cancelled' && $order->is_payment) {
            \App\Models\Refund::create([
                'order_id' => $order->id,
                'refund_number' => 'REF-' . time() . '-' . rand(1000, 9999),
                'amount' => $order->total,
                'type' => 'cancellation',
                'payment_method' => $order->payment_method,
                'reason' => 'Order cancelled by admin',
                'status' => 'pending'
            ]);
        }

        $order->update(['status' => $newStatus]);

        // Queue status update email if status changed
        if ($oldStatus !== $newStatus) {
            try {
                Mail::to($order->email)->queue(new OrderStatusUpdateMail($order, $oldStatus));
            } catch (\Exception $e) {
                \Log::error('Failed to queue order status update email: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.order.index')->with('success', 'Order status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->update(['isdelete' => true]);

        return redirect()->route('admin.order.index')->with('success', 'Order deleted successfully.');
    }

    /**
     * Toggle the payment status of the specified resource.
     */
    public function togglePaymentStatus(Order $order)
    {
        $order->update(['is_payment' => !$order->is_payment]);
        return back()->with('success', 'Order payment status updated successfully.');
    }

    /**
     * Validate status transitions
     */
    private function isValidStatusTransition($oldStatus, $newStatus)
    {
        // Same status is always valid
        if ($oldStatus === $newStatus) {
            return true;
        }

        $validTransitions = [
            'pending' => ['confirmed', 'cancelled'],
            'confirmed' => ['processing', 'cancelled'],
            'processing' => ['shipped', 'cancelled'],
            'shipped' => ['delivered', 'cancelled'],
            'delivered' => ['return_requested'], // Allow return requests from delivered
            'cancelled' => ['refunded'], // Allow refunded status from cancelled
            'return_requested' => ['return_processing', 'return_rejected'], // Admin can process or reject return
            'return_processing' => ['return_approved', 'return_rejected'], // Processing can go to approved or rejected
            'return_approved' => ['refunded'], // Approved returns can be refunded
            'return_rejected' => ['delivered'], // Rejected returns go back to delivered
            'refunded' => [] // No transitions allowed from refunded
        ];

        return in_array($newStatus, $validTransitions[$oldStatus] ?? []);
    }

    /**
     * Process PayPal refund
     */
    private function processPayPalRefund(Order $order)
    {
        try {
            $provider = new \Srmklive\PayPal\Services\PayPal;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();

            $paymentData = $order->payment_data;
            if (!$paymentData || !isset($paymentData['transaction_id'])) {
                \Log::error('PayPal refund failed: No transaction ID', ['order_id' => $order->id]);
                return false;
            }

            $response = $provider->refundCapturedPayment($paymentData['transaction_id'], 'Order cancelled', $order->total, 'USD');

            if (isset($response['status']) && $response['status'] === 'COMPLETED') {
                // Update order with refund info
                $paymentData['refund'] = [
                    'refund_id' => $response['id'],
                    'status' => 'completed',
                    'amount' => $order->total,
                    'refunded_at' => now()
                ];
                $order->update(['payment_data' => $paymentData]);

                \Log::info('PayPal refund successful', ['order_id' => $order->id, 'refund_id' => $response['id']]);
                return true;
            }

            \Log::error('PayPal refund failed', ['order_id' => $order->id, 'response' => $response]);
            return false;

        } catch (\Exception $e) {
            \Log::error('PayPal refund error: ' . $e->getMessage(), ['order_id' => $order->id]);
            return false;
        }
    }
}