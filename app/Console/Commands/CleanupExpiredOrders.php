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
            ->get();

        $count = $expiredOrders->count();
        
        foreach ($expiredOrders as $order) {
            $order->orderItems()->delete();
            $order->delete();
        }

        $this->info("Cleaned up {$count} expired orders.");
        return 0;
    }
}