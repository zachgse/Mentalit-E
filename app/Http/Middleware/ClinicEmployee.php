<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ClinicEmployee
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->userType == 'ClinicEmployee' || auth()->user()->userType == 'ClinicAdmin') {
            return $next($request);
        }
        
        abort(401);

    }
}
