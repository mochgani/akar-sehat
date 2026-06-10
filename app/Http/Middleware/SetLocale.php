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

        // Validate the locale against active languages
        $validCodes = Language::aktif()->pluck('code')->toArray();
        if (!in_array($locale, $validCodes)) {
            $locale = 'id';
        }

        app()->setLocale($locale);
        // Share locale and active languages with all views
        view()->share('currentLocale', $locale);
        view()->share('activeLanguages', Language::aktif()->get());

        return $next($request);
    }
}
