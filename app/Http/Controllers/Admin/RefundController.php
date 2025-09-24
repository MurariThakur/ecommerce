<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use App\Services\RefundService;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    public function index()
    {
        $refunds = Refund::with('order.user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

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