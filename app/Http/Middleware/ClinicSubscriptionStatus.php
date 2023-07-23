<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Employee;
use App\Models\Clinic;

class ClinicSubscriptionStatus
{

    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        $var = Employee::where('user_id', $user->id)->get()->first(); 
        $vars = Clinic::where('id', $var->clinic_id)->get()->first(); 

        if ($vars->subscriptionDuration == 0 && $user->userType == 'ClinicAdmin') {
            return redirect('/resubscribe'); 
        } elseif ($vars->subscriptionDuration == 0 && $user->userType == 'ClinicEmployee') {
            abort(405);
        } 

        return $next($request);
    }
}
