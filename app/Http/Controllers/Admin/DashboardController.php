<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $title = 'Dashboard';
        $selectedYear = $request->get('year', now()->year);

        // Get comprehensive statistics
        $stats = [
            'total_customers' => User::where('is_admin', false)->count(),
            'total_orders' => Order::where('isdelete', false)->count(),
            'total_products' => Product::where('isdelete', false)->count(),
            'total_categories' => Category::where('isdelete', false)->count(),
            'pending_orders' => Order::where('status', 'confirmed')->where('isdelete', false)->count(),
            'completed_orders' => Order::where('status', 'delivered')->where('isdelete', false)->count(),
            'total_revenue' => Order::where('status', 'delivered')->where('isdelete', false)->sum('total'),
            'monthly_revenue' => Order::where('status', 'delivered')
                ->where('isdelete', false)
                ->whereMonth('created_at', now()->month)
                ->sum('total'),
        ];

        // Recent orders
        $recentOrders = Order::with(['user'])
            ->where('isdelete', false)
            ->latest()
            ->take(5)
            ->get();

        // Monthly sales data for chart
        $monthlySales = Order::where('status', 'delivered')
            ->where('isdelete', false)
            ->whereYear('created_at', $selectedYear)
            ->selectRaw('MONTH(created_at) as month, SUM(total) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Fill missing months with 0
        $salesData = [];
        for ($i = 1; $i <= 12; $i++) {
            $salesData[] = $monthlySales[$i] ?? 0;
        }

        // Order status distribution
        $orderStatus = Order::where('isdelete', false)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Available years for filter
        $availableYears = Order::where('isdelete', false)
            ->selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        return view('admin.dashboard', compact('title', 'stats', 'recentOrders', 'salesData', 'orderStatus', 'selectedYear', 'availableYears'));
    }
}
