<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;

class UcRedirectMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $ucMode = Setting::get('uc.mode', 'off');

        if ($ucMode === 'on' && !$request->routeIs('under-construction') && !$request->routeIs('admin.*')) {
            return redirect()->route('under-construction');
        }

        return $next($request);
    }
}
