<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        // Determine locale from session, fallback to 'id'
        $locale = session('locale', 'id');

        // Single query for active languages
        $activeLanguages = Language::aktif()->get();
        if (!$activeLanguages->pluck('code')->contains($locale)) {
            $locale = 'id';
        }

        app()->setLocale($locale);
        view()->share('currentLocale', $locale);
        view()->share('activeLanguages', $activeLanguages);

        return $next($request);
    }
}
