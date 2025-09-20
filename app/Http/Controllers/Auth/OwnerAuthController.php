<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class OwnerAuthController extends Controller
{
    /**
     * Show login form.
     */
    public function showLogin()
    {
        return view('admin.login');
    }

    /**
     * Handle login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username'    => ['required'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::guard('owner')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Welcome back!');
        }

        throw ValidationException::withMessages([
            'username' => __('username email or password.'),
        ]);
    }

    /**
     * Show signup form.
     */
    public function showSignup()
    {
        return view('admin.signup');
    }

    /**
     * Handle signup.
     */
    public function signup(Request $request)
    {
        $data = $request->validate([
            'username'                  => ['required', 'string', 'max:255'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $owner = Owner::create([
            'username'     => $data['username'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::guard('owner')->login($owner);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Account created successfully.');
    }

    /**
     * Logout owner.
     */
    public function logout(Request $request)
    {
        Auth::guard('owner')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('owner.login');
    }
}
