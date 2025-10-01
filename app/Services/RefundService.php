<?php

namespace App\Services;

use App\Models\Refund;
use Exception;

class RefundService
{
    public function approveRefund(Refund $refund)
    {
        $refund->update([
            'status' => 'approved',
            'approved_at' => now()
        ]);
        
        // Auto-process for online payments
        if (in_array($refund->payment_method, ['paypal', 'stripe'])) {
            return $this->processRefund($refund);
        }
        
        return ['success' => true, 'message' => 'Refund approved successfully'];
    }
    
    public function processRefund(Refund $refund)
    {
        try {
            \Log::info('Processing refund', ['refund_id' => $refund->id, 'payment_method' => $refund->payment_method]);
            
            $refund->update(['status' => 'processing', 'processed_at' => now()]);
            
            $result = match($refund->payment_method) {
                'paypal' => $this->processPayPalRefund($refund),
                'stripe' => $this->processStripeRefund($refund),
                'cod' => $this->processCODRefund($refund),
                default => throw new Exception('Unsupported payment method: ' . $refund->payment_method)
            };

            if ($refund->payment_method === 'stripe') {
                // For Stripe, set to processing and let webhook complete it
                $refund->update([
                    'status' => 'processing',
                    'refund_data' => $result
                ]);
                
                // Update order status to refund_processing
                $refund->order->update(['status' => 'refund_processing']);
            } else {
                // For other payment methods, complete immediately
                $refund->update([
                    'status' => 'completed',
                    'completed_at' => now(),
                    'refund_data' => $result
                ]);
                
                // Update order status
                $refund->order->update(['status' => 'refunded']);
            }

            \Log::info('Refund completed successfully', ['refund_id' => $refund->id]);
            return ['success' => true, 'message' => 'Refund completed successfully'];
        } catch (Exception $e) {
            \Log::error('Refund failed', ['refund_id' => $refund->id, 'error' => $e->getMessage()]);
            
            $refund->update([
                'status' => 'failed',
                'refund_data' => ['error' => $e->getMessage(), 'failed_at' => now()]
            ]);

            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    private function processPayPalRefund(Refund $refund)
    {
        $paymentData = $refund->order->payment_data;
        
        if (!isset($paymentData['transaction_id'])) {
            throw new Exception('PayPal transaction ID not found');
        }

        // For development: Use mock refund since transaction IDs are not real PayPal charges
        // For production: Replace with real PayPal API call
        return [
            'gateway' => 'paypal',
            'refund_id' => 'PAYPAL_REF_' . time(),
            'transaction_id' => $paymentData['transaction_id'],
            'amount' => $refund->amount,
            'status' => 'completed',
            'created' => time(),
            'currency' => 'USD'
        ];
        
        /* FOR PRODUCTION WITH WEBHOOK - Uncomment this when going live:
        try {
            $provider = new \Srmklive\PayPal\Services\PayPal;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();
            
            $paypalResponse = $provider->refundCapturedPayment(
                $paymentData['transaction_id'],
                'Order refund requested by customer',
                $refund->amount,
                'USD'
            );
            
            // For production: Set to processing and let webhook complete it
            $refund->update([
                'status' => 'processing',
                'refund_data' => [
                    'gateway' => 'paypal',
                    'refund_id' => $paypalResponse['id'],
                    'transaction_id' => $paymentData['transaction_id'],
                    'amount' => $refund->amount,
                    'status' => $paypalResponse['status'],
                    'created' => time(),
                    'currency' => 'USD'
                ]
            ]);
            
            $refund->order->update(['status' => 'refund_processing']);
            
            return [
                'gateway' => 'paypal',
                'refund_id' => $paypalResponse['id'],
                'transaction_id' => $paymentData['transaction_id'],
                'amount' => $refund->amount,
                'status' => $paypalResponse['status'],
                'created' => time(),
                'currency' => 'USD'
            ];
            
        } catch (\Exception $e) {
            throw new Exception('PayPal refund failed: ' . $e->getMessage());
        }
        */
    }

    private function processStripeRefund(Refund $refund)
    {
        $paymentData = $refund->order->payment_data;
        
        if (!isset($paymentData['transaction_id'])) {
            throw new Exception('Stripe transaction ID not found');
        }

        // For development: Use mock refund since transaction IDs are not real Stripe charges
        // For production: Replace with real Stripe API call
        return [
            'gateway' => 'stripe',
            'refund_id' => 're_' . time() . rand(1000, 9999),
            'transaction_id' => $paymentData['transaction_id'],
            'amount' => $refund->amount,
            'status' => 'succeeded',
            'created' => time(),
            'currency' => 'usd'
        ];
        
        /* FOR PRODUCTION - Uncomment this when going live:
        try {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            
            $stripeResponse = \Stripe\Refund::create([
                'charge' => $paymentData['transaction_id'],
                'amount' => $refund->amount * 100,
                'reason' => 'requested_by_customer'
            ]);
            
            return [
                'gateway' => 'stripe',
                'refund_id' => $stripeResponse->id,
                'transaction_id' => $paymentData['transaction_id'],
                'amount' => $refund->amount,
                'status' => $stripeResponse->status,
                'created' => $stripeResponse->created,
                'currency' => $stripeResponse->currency
            ];
            
        } catch (\Exception $e) {
            throw new Exception('Stripe refund failed: ' . $e->getMessage());
        }
        */
    }

    private function processCODRefund(Refund $refund)
    {
        return [
            'gateway' => 'cod',
            'refund_id' => 'COD_REF_' . time(),
            'amount' => $refund->amount,
            'status' => 'completed',
            'note' => 'COD refund - Amount will be credited to original payment method within 7-10 business days'
        ];
    }
    
    public function rejectRefund(Refund $refund, $reason)
    {
        $refund->update([
            'status' => 'rejected',
            'admin_notes' => $reason
        ]);
        
        // Update order status based on type
        if ($refund->type === 'return') {
            $refund->order->update(['status' => 'return_rejected']);
        }
        
        return ['success' => true, 'message' => 'Refund rejected'];
    }
}