<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check() && Auth::user()->is_super_admin) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => ['required_without:email', 'nullable', 'string', 'max:150'],
            'email' => ['required_without:login', 'nullable', 'string', 'max:150'],
            'password' => ['required', 'string'],
        ]);

        $identifier = (string) ($credentials['login'] ?? $credentials['email'] ?? '');
        $user = User::findByLoginIdentifier($identifier);

        if ($user && $user->is_super_admin && $user->password && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'))->with('success', 'Welcome back, Super Admin!');
        }

        return back()->withErrors([
            'email' => 'Invalid Super Admin credentials or insufficient privileges.',
        ])->onlyInput('email', 'login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Logged out successfully.');
    }
}
