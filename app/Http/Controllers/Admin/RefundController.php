<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use App\Services\RefundService;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    public function index(Request $request)
    {
        $query = Refund::with('order.user');

        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('refund_number', 'like', "%{$search}%")
                  ->orWhereHas('order', function($orderQuery) use ($search) {
                      $orderQuery->where('order_number', 'like', "%{$search}%")
                                 ->orWhereHas('user', function($userQuery) use ($search) {
                                     $userQuery->where('name', 'like', "%{$search}%")
                                              ->orWhere('email', 'like', "%{$search}%");
                                 });
                  });
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $refunds = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.refunds.index', compact('refunds'));
    }

    public function show($id)
    {
        $refund = Refund::with('order.user', 'order.orderItems.product')
            ->findOrFail($id);

        return view('admin.refunds.show', compact('refund'));
    }

    public function process(Request $request, $id)
    {
        $refund = Refund::findOrFail($id);
        $refundService = new RefundService();

        $result = $refundService->processRefund($refund);

        return redirect()->back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    public function approve(Request $request, $id)
    {
        $refund = Refund::findOrFail($id);
        $refundService = new RefundService();

        $refund->update([
            'admin_notes' => $request->notes,
            'refund_data' => ['approved_by' => auth()->user()->name]
        ]);

        $result = $refundService->approveRefund($refund);

        return redirect()->back()->with('success', $result['message']);
    }

    public function reject(Request $request, $id)
    {
        $refund = Refund::findOrFail($id);
        $refundService = new RefundService();

        $result = $refundService->rejectRefund($refund, $request->reason);

        return redirect()->back()->with('success', $result['message']);
    }
}