<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLocales = array_keys(config('locales.supported', []));
        $fallback = config('app.locale', 'en');

        $locale = session('locale');

        if (!$locale) {
            $locale = $request->cookie('locale', $fallback);
        }

        if (!in_array($locale, $supportedLocales, true)) {
            $locale = $fallback;
        }

        session(['locale' => $locale]);
        app()->setLocale($locale);

        return $next($request);
    }
}

