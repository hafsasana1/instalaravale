<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\URL;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $locale = session('locale', config('app.locale'));

        if ($request->route('locale')) {
            $fallback = $locale;

            $locale = $request->route('locale', $fallback);
            $locales = data_get(app('theme.locales'), 'enabled', []);
            $locales = array_keys($locales);

            if (!in_array($locale, $locales))
                abort(404);

            if ($locale != session('locale'))
                session()->put('locale', $locale);
        }

        URL::defaults(compact('locale'));
        app()->setLocale($locale);

        return $next($request);
    }
}
