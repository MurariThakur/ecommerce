<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;

class CleanupExpiredOrders extends Command
{
    protected $signature = 'orders:cleanup-expired';
    protected $description = 'Delete expired pending orders';

    public function handle()
    {
        $expiredOrders = Order::where('status', 'pending')
            ->where('expires_at', '<', now())
            ->where(function ($query) {
                // Only expire orders that haven't been sent to payment gateway
                $query->where('payment_method', 'cash')
                    ->orWhereNull('payment_data')
                    ->orWhere('payment_data', '{}');
            })
            ->get();

        $count = $expiredOrders->count();

        foreach ($expiredOrders as $order) {
            $order->orderItems()->delete();
            $order->delete();
        }

        $this->info("Deleted {$count} expired orders.");
        return 0;
    }
}