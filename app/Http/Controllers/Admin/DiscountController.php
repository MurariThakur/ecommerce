<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Http\Requests\DiscountRequest;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::notDeleted()
            ->latest()
            ->paginate(10);
        return view('admin.discount.index', compact('discounts'));
    }

    public function create()
    {
        return view('admin.discount.create');
    }

    public function store(DiscountRequest $request)
    {
        try {
            Discount::create($request->validated());
            return redirect()->route('admin.discount.index')
                ->with('success', 'Discount created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error creating discount: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Discount $discount)
    {
        return view('admin.discount.show', compact('discount'));
    }

    public function edit(Discount $discount)
    {
        return view('admin.discount.edit', compact('discount'));
    }

    public function update(DiscountRequest $request, Discount $discount)
    {
        try {
            $discount->update($request->validated());
            return redirect()->route('admin.discount.index')
                ->with('success', 'Discount updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating discount: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Discount $discount)
    {
        try {
            $discount->update(['is_deleted' => true]);
            return redirect()->route('admin.discount.index')
                ->with('success', 'Discount deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting discount: ' . $e->getMessage());
        }
    }

    public function toggleStatus(Discount $discount)
    {
        try {
            $discount->update(['status' => !$discount->status]);
            return redirect()->back()
                ->with('success', 'Discount status updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating status: ' . $e->getMessage());
        }
    }
}
