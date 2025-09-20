<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckOwner
{
    public function handle(Request $request, Closure $next)
    {
        // Check if owner is logged in
        if (!Auth::guard('owner')->check()) {
            // If not logged in as owner, redirect to owner login
            return redirect()->route('owner.login')->withErrors([
                'auth' => 'You must be logged in as Owner to access this page.'
            ]);
        }

        return $next($request);
    }
}
