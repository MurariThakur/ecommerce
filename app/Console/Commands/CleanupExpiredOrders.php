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
        // Debug: Show all pending orders
        $allPending = Order::where('status', 'pending')->get();
        $this->info("Total pending orders: {$allPending->count()}");
        
        foreach ($allPending as $order) {
            $this->info("Order {$order->id}: expires_at={$order->expires_at}, now=" . now() . ", payment_method={$order->payment_method}, payment_data=" . ($order->payment_data ?? 'null'));
        }

        $expiredOrders = Order::where('status', 'pending')
            ->where('expires_at', '<', now())
            ->get();

        $count = $expiredOrders->count();
        $this->info("Expired orders to delete: {$count}");

        foreach ($expiredOrders as $order) {
            $this->info("Deleting order {$order->id}");
            $order->orderItems()->delete();
            $order->delete();
        }

        $this->info("Deleted {$count} expired orders.");
        return 0;
    }
}