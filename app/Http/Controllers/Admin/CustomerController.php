<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('is_admin', false);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $customers = $query->latest()->paginate(10)->appends($request->query());

        return view('admin.customer.index', compact('customers'));
    }



    public function show(User $customer)
    {
        if ($customer->is_admin) {
            abort(404);
        }
        return view('admin.customer.show', compact('customer'));
    }



    public function destroy(User $customer)
    {
        if ($customer->is_admin) {
            abort(404);
        }

        $customer->delete();
        return redirect()->route('admin.customer.index')->with('success', 'Customer deleted successfully.');
    }

    public function toggleStatus(User $customer)
    {
        if ($customer->is_admin) {
            abort(404);
        }

        $customer->update(['is_active' => !$customer->is_active]);
        return back()->with('success', 'Customer status updated successfully.');
    }
}