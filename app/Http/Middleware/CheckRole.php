<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!$request->user() || !$request->user()->role) {
            abort(403);
        }

        if (in_array($request->user()->role->nom, $roles)) {
            return $next($request);
        }

        abort(403);
    }
}
