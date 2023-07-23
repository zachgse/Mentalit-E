<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\Booking;

class EmployeeBooking2
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
        $employee = Employee::where('user_id', $user->id)->get()->first();

        $booking = $request->booking;
        
        if ($booking == null) {
            abort (401); 
        }
        if ($employee->id != $booking->employee_id) {
            abort (401); 
        } 
        
        return $next($request);
    }
}
