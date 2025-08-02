<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        // Redirect if already authenticated
        if (Auth::check()) {
            return redirect()->intended('/admin/dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        // Check if already authenticated
        if (Auth::check()) {
            return redirect()->intended('/admin/dashboard');
        }

        // Rate limiting to prevent brute force attacks
        $key = Str::lower($request->input('email')) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'email' => "Too many login attempts. Please try again in {$seconds} seconds."
            ])->withInput($request->only('email'));
        }

        // Convert remember field from 'on' to boolean
        $data = $request->all();
        $data['remember'] = $request->has('remember') ? true : false;

        // Validate input
        $validator = Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
            'remember' => ['boolean']
        ]);

        if ($validator->fails()) {
            RateLimiter::hit($key);
            return back()->withErrors($validator)->withInput($request->only('email'));
        }


        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        // Check if user exists and is admin
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            RateLimiter::hit($key);
            return back()->withErrors([
                'email' => 'No account found with this email address.'
            ])->withInput($request->only('email'));
        }

        if ($user->is_admin != 1) {
            RateLimiter::hit($key);
            return back()->withErrors([
                'email' => 'You do not have admin access.'
            ])->withInput($request->only('email'));
        }

        // Check if user account is active
        if (!$user->isActive()) {
            RateLimiter::hit($key);
            return back()->withErrors([
                'email' => 'Your account has been deactivated. Please contact administrator.'
            ])->withInput($request->only('email'));
        }

        // Check if user is an admin
        if (!$user->isAdmin()) {
            RateLimiter::hit($key);
            return back()->withErrors([
                'email' => 'Access denied. Admin privileges required.'
            ])->withInput($request->only('email'));
        }

        // Check if account is locked
        if ($user->isLocked()) {
            RateLimiter::hit($key);
            $unlockTime = $user->locked_until->diffForHumans();
            return back()->withErrors([
                'email' => "Account is temporarily locked. Try again {$unlockTime}."
            ])->withInput($request->only('email'));
        }

        // Attempt authentication
        if (Auth::attempt($credentials, $remember)) {
            // Clear rate limiting on successful login
            RateLimiter::clear($key);

            // Regenerate session to prevent session fixation
            $request->session()->regenerate();

            // Update last login time
            $user->updateLastLogin();

            // Log successful login
            \Log::info('User logged in successfully', [
                'user_id' => Auth::id(),
                'email' => Auth::user()->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return redirect()->intended('/admin/dashboard')
                ->with('success', 'Welcome back, ' . Auth::user()->name . '!');
        }

        // Authentication failed
        RateLimiter::hit($key);

        // Log failed login attempt
        \Log::warning('Failed login attempt', [
            'email' => $credentials['email'],
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return back()->withErrors([
            'email' => 'Invalid email or password.'
        ])->withInput($request->only('email'));
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('info', 'You are already logged out.');
        }

        // Log logout
        \Log::info('User logged out', [
            'user_id' => Auth::id(),
            'email' => Auth::user()->email,
            'ip' => $request->ip()
        ]);

        // Get user name before logout
        $userName = Auth::user()->name;

        // Logout user
        Auth::logout();

        // Invalidate session
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();

        return redirect('/admin/login')
            ->with('success', 'You have been logged out successfully.');
    }

    /**
     * Force logout from all devices
     */
    public function logoutFromAllDevices(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'You must be logged in to perform this action.');
        }

        $user = Auth::user();

        // Log the action
        \Log::info('User logged out from all devices', [
            'user_id' => $user->id,
            'email' => $user->email,
            'ip' => $request->ip()
        ]);

        // Logout from all devices by updating remember_token
        $user->update([
            'remember_token' => Str::random(60)
        ]);

        // Logout current session
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login')
            ->with('success', 'You have been logged out from all devices successfully.');
    }

    /**
     * Check authentication status (for AJAX requests)
     */
    public function checkAuth(Request $request)
    {
        if ($request->ajax()) {
            return response()->json([
                'authenticated' => Auth::check(),
                'user' => Auth::check() ? Auth::user()->only(['id', 'name', 'email']) : null
            ]);
        }

        return Auth::check() ? response('Authenticated', 200) : response('Unauthenticated', 401);
    }

    /**
     * Handle session timeout
     */
    public function sessionTimeout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Your session has expired. Please login again.'
            ], 401);
        }

        return redirect('/admin/login')
            ->with('warning', 'Your session has expired. Please login again.');
    }
}
