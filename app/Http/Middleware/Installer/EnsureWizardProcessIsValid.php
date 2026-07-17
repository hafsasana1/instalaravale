<?php

namespace App\Http\Middleware\Installer;

use App\Traits\Wizard;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class EnsureWizardProcessIsValid
{
    use Wizard;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        if ($route = $this->currentStep()) {
            if (!Route::has($route))
                return redirect()->route("installer.index");
            $currentRouteName = $request->route()->getName();
            if ($currentRouteName && !Str::startsWith($currentRouteName, $route))
                return redirect()->route($route);
        }

        return $next($request);
    }
}
