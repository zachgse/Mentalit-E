<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\Booking;

class ClinicBooking
{

    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        $employee = Employee::where('user_id', $user->id)->get('clinic_id')->first();

        $booking = $request->id;
        $var = Booking::find($booking);

        if ($var == null) {
            abort (401); 
        }

        if ($employee->clinic_id != $var->clinic_id) {
            abort (401); 
        } 
        
        return $next($request);
    }
}
