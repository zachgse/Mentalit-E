<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use App\Models\Clinic;

class EmployeeStatus
{

    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        $var = Employee::where('user_id', $user->id)->get()->first(); 
        $vars = Clinic::where('id', $var->clinic_id)->get()->first(); 

        if ($var->accountStatus == "Pending" || $var->accountStatus == "Inactive" && $user->userType == "ClinicAdmin") {
            abort(405);
        }
        elseif ($var->accountStatus == "Pending" || $var->accountStatus == "Inactive" && $user->userType == "ClinicEmployee") {
            abort(406);
        }

        return $next($request);

    }
}
