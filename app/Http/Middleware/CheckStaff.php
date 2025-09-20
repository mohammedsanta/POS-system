<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckStaff
{
    public function handle(Request $request, Closure $next)
    {
        // Check if staff is logged in
        if (!Auth::guard('staff')->check()) {
            // If not logged in as staff, redirect to staff login
            return redirect()->route('login')->withErrors([
                'auth' => 'You must be logged in as Staff to access this page.'
            ]);
        }

        return $next($request);
    }
}
