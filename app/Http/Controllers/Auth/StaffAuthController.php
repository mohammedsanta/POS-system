<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffAuthController extends Controller
{
        /**
     * Show the staff login form.
     */
    public function showLogin()
    {
        return view('staff.Auth.login');
    }

    /**
     * Handle staff login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required|min:6',
        ]);

        // محاولة تسجيل الدخول
        if (Auth::guard('staff')->attempt($credentials)) {
            $request->session()->regenerate(); // لتجنب هجمات الـ session fixation
            return redirect()->intended('/cashier/dashboard')
                ->with('success', 'Welcome back!');
        }

        return back()->withErrors([
            'username' => 'Invalid username or password.',
        ])->onlyInput('username');
    }

    /**
     * Log the staff user out.
     */
    public function logout(Request $request)
    {
        Auth::guard('staff')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'You have been logged out.');
    }

}
