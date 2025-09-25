<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('admin')->user()->isAdmin()) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Access denied. Admin privileges required.'], 403);
            }
            
            return redirect('/admin/login')->with('error', 'Access denied. You need admin privileges to access this area.');
        }

        return $next($request);
    }
}
