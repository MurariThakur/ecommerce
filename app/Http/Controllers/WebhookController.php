<?php

namespace App\Http\Controllers;

use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function stripeWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
        } catch (\UnexpectedValueException $e) {
            Log::error('Invalid payload in Stripe webhook', ['error' => $e->getMessage()]);
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error('Invalid signature in Stripe webhook', ['error' => $e->getMessage()]);
            return response('Invalid signature', 400);
        }

        Log::info('Stripe webhook received', ['event_type' => $event['type']]);

        switch ($event['type']) {
            case 'charge.dispute.created':
                $this->handleChargeDispute($event['data']['object']);
                break;
            case 'refund.created':
                $this->handleRefundCreated($event['data']['object']);
                break;
            case 'refund.updated':
                $this->handleRefundUpdated($event['data']['object']);
                break;
            default:
                Log::info('Unhandled Stripe webhook event', ['event_type' => $event['type']]);
        }

        return response('Webhook handled', 200);
    }

    private function handleRefundCreated($refundData)
    {
        Log::info('Stripe refund created webhook', ['refund_id' => $refundData['id']]);

        $refund = Refund::where('refund_data->refund_id', $refundData['id'])->first();

        if ($refund) {
            $refund->update([
                'status' => 'processing',
                'refund_data' => array_merge($refund->refund_data ?? [], [
                    'stripe_status' => $refundData['status'],
                    'webhook_received' => now()
                ])
            ]);
        }
    }

    private function handleRefundUpdated($refundData)
    {
        Log::info('Stripe refund updated webhook', [
            'refund_id' => $refundData['id'],
            'status' => $refundData['status']
        ]);

        $refund = Refund::where('refund_data->refund_id', $refundData['id'])->first();

        if ($refund) {
            if ($refundData['status'] === 'succeeded') {
                $refund->update([
                    'status' => 'completed',
                    'completed_at' => now(),
                    'refund_data' => array_merge($refund->refund_data ?? [], [
                        'stripe_status' => 'succeeded',
                        'completed_via_webhook' => now()
                    ])
                ]);

                // Update order status to refunded
                $refund->order->update(['status' => 'refunded']);

                Log::info('Refund completed via webhook', ['refund_id' => $refund->id]);
            } elseif ($refundData['status'] === 'failed') {
                $refund->update([
                    'status' => 'failed',
                    'refund_data' => array_merge($refund->refund_data ?? [], [
                        'stripe_status' => 'failed',
                        'failure_reason' => $refundData['failure_reason'] ?? 'Unknown',
                        'failed_via_webhook' => now()
                    ])
                ]);

                Log::error('Refund failed via webhook', [
                    'refund_id' => $refund->id,
                    'reason' => $refundData['failure_reason'] ?? 'Unknown'
                ]);
            }
        }
    }

    public function paypalWebhook(Request $request)
    {
        $payload = $request->all();

        Log::info('PayPal webhook received', ['event_type' => $payload['event_type'] ?? 'unknown']);

        switch ($payload['event_type'] ?? '') {
            case 'PAYMENT.CAPTURE.REFUNDED':
                $this->handlePayPalRefund($payload['resource']);
                break;
            default:
                Log::info('Unhandled PayPal webhook event', ['event_type' => $payload['event_type'] ?? 'unknown']);
        }

        return response('Webhook handled', 200);
    }

    private function handlePayPalRefund($refundData)
    {
        Log::info('PayPal refund webhook', [
            'refund_id' => $refundData['id'],
            'status' => $refundData['status']
        ]);

        $refund = Refund::where('refund_data->refund_id', $refundData['id'])->first();

        if ($refund) {
            if ($refundData['status'] === 'COMPLETED') {
                $refund->update([
                    'status' => 'completed',
                    'completed_at' => now(),
                    'refund_data' => array_merge($refund->refund_data ?? [], [
                        'paypal_status' => 'COMPLETED',
                        'completed_via_webhook' => now()
                    ])
                ]);

                $refund->order->update(['status' => 'refunded']);

                Log::info('PayPal refund completed via webhook', ['refund_id' => $refund->id]);
            } elseif ($refundData['status'] === 'FAILED') {
                $refund->update([
                    'status' => 'failed',
                    'refund_data' => array_merge($refund->refund_data ?? [], [
                        'paypal_status' => 'FAILED',
                        'failed_via_webhook' => now()
                    ])
                ]);

                Log::error('PayPal refund failed via webhook', ['refund_id' => $refund->id]);
            }
        }
    }

    private function handleChargeDispute($disputeData)
    {
        Log::warning('Charge dispute created', [
            'dispute_id' => $disputeData['id'],
            'charge_id' => $disputeData['charge'],
            'reason' => $disputeData['reason']
        ]);
    }
}