<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Order;
use App\Models\Review;

class UserDashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        $stats = [
            'total_orders' => Order::where('user_id', $user->id)->where('isdelete', false)->where('status', '!=', 'pending')->count(),
            'pending_orders' => Order::where('user_id', $user->id)->where('status', 'confirmed')->where('isdelete', false)->count(),
            'delivered_orders' => Order::where('user_id', $user->id)->where('status', 'delivered')->where('isdelete', false)->count(),
            'total_spent' => Order::where('user_id', $user->id)->where('status', 'delivered')->where('isdelete', false)->sum('total'),
        ];

        $recentOrders = Order::where('user_id', $user->id)
            ->where('isdelete', false)
            ->where('status', '!=', 'pending')
            ->latest()
            ->take(5)
            ->get();

        return view('frontend.user.dashboard', compact('stats', 'recentOrders'));
    }

    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->where('isdelete', false)
            ->where('status', '!=', 'pending')
            ->with('orderItems.product')
            ->latest()
            ->paginate(10);

        // Add review status for delivered orders
        foreach ($orders as $order) {
            if ($order->status === 'delivered') {
                foreach ($order->orderItems as $item) {
                    $item->has_review = Review::where('user_id', Auth::id())
                        ->where('product_id', $item->product_id)
                        ->exists();
                }
            }
        }

        return view('frontend.user.orders', compact('orders'));
    }

    public function orderDetails($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->where('id', $id)
            ->where('isdelete', false)
            ->where('status', '!=', 'pending')
            ->with(['orderItems.product', 'shipping'])
            ->firstOrFail();

        return view('frontend.user.order-details', compact('order'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('frontend.user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:100',
            'address_line_1' => 'nullable|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
        ]);

        $user = Auth::user();
        $user->update($request->only([
            'name',
            'phone',
            'company',
            'country',
            'address_line_1',
            'address_line_2',
            'city',
            'state',
            'postal_code'
        ]));

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully!');
    }

    public function changePassword()
    {
        return view('frontend.user.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        Auth::user()->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('user.change-password')->with('success', 'Password updated successfully!');
    }

    public function cancelOrder($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->where('id', $id)
            ->where('isdelete', false)
            ->whereIn('status', ['confirmed', 'processing', 'shipped'])
            ->firstOrFail();

        // Prevent cancellation of delivered orders
        if ($order->status === 'delivered') {
            return redirect()->back()->with('error', 'Cannot cancel delivered orders.');
        }

        $order->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Order cancelled successfully.');
    }
}