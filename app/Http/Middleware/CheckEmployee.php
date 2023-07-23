<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;

class CheckEmployee
{

    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        $employee = Employee::where('user_id', $user->id)->get()->first();
   
        if ($employee != null) {
            abort (422);
        }
        
        return $next($request);
    }
}
