<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Employee;


class ClinicStatus
{

    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user(); 
        $var = Employee::where('user_id', $user->id)->get()->first();
 
        if ($var == null && $user->userType == 'ClinicAdmin') {
            return redirect ('/clinic/clinic/create');
        } elseif ($var == null && $user->userType == 'ClinicEmployee') {
            return redirect('/apply');
        } elseif ($user->userType == 'Patient' || $user->userType == 'SystemAdmin') {
            abort(401);
        }
        
        return $next($request);

    }
}
