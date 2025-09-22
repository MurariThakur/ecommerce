<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems'])
            ->where('isdelete', false)
            ->whereIn('status', ['confirmed', 'processing', 'shipped', 'delivered', 'cancelled']);

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
            'status' => 'required|in:confirmed,processing,shipped,delivered,cancelled'
        ]);

        // If cancelling a paid PayPal order, process refund
        if ($request->status === 'cancelled' && $order->is_payment && $order->payment_method === 'paypal') {
            $this->processPayPalRefund($order);
        }

        $order->update(['status' => $request->status]);

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