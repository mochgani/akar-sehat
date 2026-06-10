<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next, string $role = null)
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        $user = Auth::user();

        if ($user->status !== 'aktif') {
            Auth::logout();
            return redirect()->route('admin.login')->withErrors(['login' => 'Akun Anda tidak aktif.']);
        }

        if ($role && !$this->hasRole($user, $role)) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }

    private function hasRole($user, string $requiredRole): bool
    {
        $hierarchy = ['administrator' => 4, 'editor' => 3, 'penulis' => 2, 'viewer' => 1];
        return ($hierarchy[$user->role] ?? 0) >= ($hierarchy[$requiredRole] ?? 0);
    }
}
