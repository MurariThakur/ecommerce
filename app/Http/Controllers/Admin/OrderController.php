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
    public function index()
    {
        $orders = Order::with(['user', 'orderItems'])
            ->where('isdelete', false)
            ->whereIn('status', ['confirmed', 'processing', 'shipped', 'delivered', 'cancelled'])
            ->latest()
            ->paginate(10);
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