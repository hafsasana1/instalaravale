<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class EnsureAppIsInstalled
{
    /**
     * This middleware is bypassed — the app ships pre-configured without
     * the installer wizard.
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        return $next($request);
    }
}
