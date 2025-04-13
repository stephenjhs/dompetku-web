<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class MemberMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'member') {
            return $next($request);
        }


        abort(403, 'Akses hanya untuk member.');
    }
}

