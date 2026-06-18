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
        // Single query for active languages
        $activeLanguages = Language::aktif()->get();

        // Default display language for first-time visitors (admin-configurable).
        // Falls back to 'id' if no default is flagged or it is inactive.
        $defaultLocale = optional($activeLanguages->firstWhere('is_default', true))->code ?? 'id';

        // Determine locale from session, fallback to the configured default
        $locale = session('locale', $defaultLocale);

        if (!$activeLanguages->pluck('code')->contains($locale)) {
            $locale = $activeLanguages->pluck('code')->contains($defaultLocale) ? $defaultLocale : 'id';
        }

        app()->setLocale($locale);
        view()->share('currentLocale', $locale);
        view()->share('activeLanguages', $activeLanguages);

        return $next($request);
    }
}
