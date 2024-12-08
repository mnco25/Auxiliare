<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Entrepreneur
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->user_type === 'Entrepreneur') {
            return $next($request);
        }

        return redirect()->route('login')->with('error_message', 'Unauthorized access.');
    }
}
