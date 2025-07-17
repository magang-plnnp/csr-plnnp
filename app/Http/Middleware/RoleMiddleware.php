<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) return redirect('/login');

        if (in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }

        return abort(403); // atau redirect('/unauthorized');
    }
}
