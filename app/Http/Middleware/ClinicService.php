<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\Service;

class ClinicService
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
        $user = auth()->user();
        $employee = Employee::where('user_id', $user->id)->get('clinic_id')->first();

        $service = $request->id;
        $var = Service::find($service);

        if ($var == null) {
            abort (401); 
        }

        if ($employee->clinic_id != $var->clinic_id) {
            abort (401); 
        }
        
        return $next($request);
    }
}
