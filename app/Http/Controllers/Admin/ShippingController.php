<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shipping;
use App\Http\Requests\ShippingRequest;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function index(Request $request)
    {
        $query = Shipping::notDeleted();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status === 'active');
        }

        // Date filters
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $shippings = $query->latest()->paginate(10)->appends($request->query());
        return view('admin.shipping.index', compact('shippings'));
    }

    public function create()
    {
        return view('admin.shipping.create');
    }

    public function store(ShippingRequest $request)
    {
        try {
            Shipping::create($request->validated());
            return redirect()->route('admin.shipping.index')
                ->with('success', 'Shipping method created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error creating shipping method: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Shipping $shipping)
    {
        return view('admin.shipping.show', compact('shipping'));
    }

    public function edit(Shipping $shipping)
    {
        return view('admin.shipping.edit', compact('shipping'));
    }

    public function update(ShippingRequest $request, Shipping $shipping)
    {
        try {
            $shipping->update($request->validated());
            return redirect()->route('admin.shipping.index')
                ->with('success', 'Shipping method updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating shipping method: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Shipping $shipping)
    {
        try {
            $shipping->update(['is_deleted' => true]);
            return redirect()->route('admin.shipping.index')
                ->with('success', 'Shipping method deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting shipping method: ' . $e->getMessage());
        }
    }

    public function toggleStatus(Shipping $shipping)
    {
        try {
            $shipping->update(['status' => !$shipping->status]);
            return redirect()->back()
                ->with('success', 'Shipping method status updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating status: ' . $e->getMessage());
        }
    }
}
