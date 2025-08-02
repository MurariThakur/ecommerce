<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $title = 'Admin Management';

        $admins = User::orderBy('created_at', 'desc')
                     ->paginate(10);

        return view('admin.admin.index', compact('title', 'admins'));
    }
    public function create()
    {
        $title = 'Create Admin';

        return view('admin.admin.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'is_admin' => 1,
            'is_active' => 1,
        ]);

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
    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
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
        if ($admin->id === Auth::id()) {
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
        if ($admin->id === Auth::id()) {
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
