<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPartnerRole
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->level === 'partner') {
            return $next($request);
        }

        return redirect('/')->with('error', 'You do not have permission to access this page.');
    }
}
