<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class LoadUserRole
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            Auth::user()->load('role');
        }

        return $next($request);
    }
}
