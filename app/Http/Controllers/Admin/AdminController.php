<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Admin Management';

        $query = User::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Date filters
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $admins = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->query());

        return view('admin.admin.index', compact('title', 'admins'));
    }
    public function create()
    {
        $title = 'Create Admin';

        return view('admin.admin.create', compact('title'));
    }

    public function store(AdminRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        $data['is_admin'] = 1;
        $data['is_active'] = 1;

        User::create($data);

        return redirect()->route('admin.index')
            ->with('success', 'Admin created successfully!');
    }

    /**
     * Show admin details
     */
    public function show($id)
    {
        $title = 'View Admin';
        $admin = User::findOrFail($id);

        return view('admin.admin.show', compact('title', 'admin'));
    }

    /**
     * Edit admin
     */
    public function edit($id)
    {
        $title = 'Edit Admin';
        $admin = User::findOrFail($id);

        return view('admin.admin.edit', compact('title', 'admin'));
    }

    /**
     * Update admin
     */
    public function update(AdminRequest $request, $id)
    {
        $admin = User::findOrFail($id);

        $data = $request->validated();
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        if ($request->filled('password')) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $admin->update($data);

        return redirect()->route('admin.index')
            ->with('success', 'Admin updated successfully!');
    }

    /**
     * Delete admin
     */
    public function destroy($id)
    {
        $admin = User::findOrFail($id);

        // Prevent deleting current user
        if ($admin->id === Auth::guard('admin')->id()) {
            return back()->with('error', 'You cannot delete your own account!');
        }

        $admin->delete();

        return redirect()->route('admin.index')
            ->with('success', 'Admin deleted successfully!');
    }

    /**
     * Toggle admin status
     */
    public function toggleStatus($id)
    {
        $admin = User::findOrFail($id);

        // Prevent deactivating current user
        if ($admin->id === Auth::guard('admin')->id()) {
            return back()->with('error', 'You cannot deactivate your own account!');
        }

        $admin->update([
            'is_active' => !$admin->is_active
        ]);

        $status = $admin->is_active ? 'activated' : 'deactivated';

        return redirect()->route('admin.index')
            ->with('success', "Admin {$status} successfully!");
    }
}
