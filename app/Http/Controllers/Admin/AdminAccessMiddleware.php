<?php

namespace App\Http\Controllers\Admin;

use Closure;
use Illuminate\Http\Request;

trait AdminAccessMiddleware
{
    protected function makeIsAdminMiddleware()
    {
        return function (Request $request, Closure $next) {
            if (!auth()->user()->is_admin) {
                return back()->with('message', [
                    'type' => 'error',
                    'content' => 'Only admins can access this page or action.'
                ]);
            }

            return $next($request);
        };
    }
}
