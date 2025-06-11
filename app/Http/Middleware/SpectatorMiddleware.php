<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpectatorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->isSpectator()) {
            return redirect()->route('dashboard')->with('error', 'Access denied. Spectator role required.');
        }

        return $next($request);
    }
}