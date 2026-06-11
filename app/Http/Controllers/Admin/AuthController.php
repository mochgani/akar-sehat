<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        $siteSettings = Setting::getGroup('site');
        return view('admin.login', compact('siteSettings'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        $loginField = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $attempt = Auth::attempt([$loginField => $credentials['login'], 'password' => $credentials['password']], $request->boolean('remember'));

        if (!$attempt) {
            return back()->withErrors(['login' => 'Username/email atau password salah.'])->withInput($request->only('login'));
        }

        $user = Auth::user();
        if ($user->status !== 'aktif') {
            Auth::logout();
            return back()->withErrors(['login' => 'Akun Anda tidak aktif. Hubungi administrator.']);
        }

        $user->increment('login_count');
        $user->update(['last_login_at' => now()]);

        $request->session()->regenerate();
        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
