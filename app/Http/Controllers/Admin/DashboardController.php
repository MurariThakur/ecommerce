<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $title = 'Dashboard';

        // Get some basic statistics for dashboard
        $stats = [
            'total_users' => User::count(),
            'total_admins' => User::where('is_admin', 1)->count(),
            'active_users' => User::where('is_active', 1)->count(),
            'inactive_users' => User::where('is_active', 0)->count(),
        ];

        return view('admin.dashboard', compact('title', 'stats'));
    }
}
