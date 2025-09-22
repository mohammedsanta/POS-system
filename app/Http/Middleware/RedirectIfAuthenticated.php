<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

                // لو عندك حقل role في جدول users
                if (isset($user->role)) {
                    if ($user->role === 'owner') {
                        return redirect()->route('admin.dashboard');
                    } elseif ($user->role === 'staff') {
                        return redirect()->route('cashier.dashboard');
                    }
                }

                // لو بتستخدم Guards مختلفة بدلاً من حقل role
                if ($guard === 'owner') {
                    return redirect()->route('admin.dashboard');
                } elseif ($guard === 'staff') {
                    return redirect()->route('cashier.dashboard');
                }

                // الافتراضي
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
