<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class LanguageController extends Controller
{
    /**
     * Handle switching the active application locale.
     */
    public function switch(Request $request, string $locale): RedirectResponse
    {
        $supportedLocales = $this->supportedLocales();

        if (!Arr::exists($supportedLocales, $locale)) {
            abort(404);
        }

        session(['locale' => $locale]);
        cookie()->queue(cookie('locale', $locale, 60 * 24 * 365));

        $redirectUrl = $this->resolveRedirectUrl($request->query('redirect'));

        return redirect()->to($redirectUrl ?? url()->previous() ?? route('home'));
    }

    /**
     * Resolve a safe redirect URL within the application.
     */
    protected function resolveRedirectUrl(?string $redirect): ?string
    {
        if (!$redirect) {
            return null;
        }

        // Ensure the redirect stays within the same host to avoid open redirects.
        $appUrl = config('app.url');
        $parsedRedirect = parse_url($redirect);

        if (isset($parsedRedirect['host'])) {
            $parsedApp = parse_url($appUrl);
            if (($parsedRedirect['host'] ?? null) !== ($parsedApp['host'] ?? null)) {
                return null;
            }
        }

        return $redirect;
    }

    /**
     * List of supported locales keyed by locale code.
     *
     * @return array<string,array{label:string, short:string}>
     */
    protected function supportedLocales(): array
    {
        return config('locales.supported', []);
    }
}

