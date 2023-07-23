<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','clinic_id','service_id',
        'employee_id','start','end',
        'link','status', 'payment', 
        'reason','consent', 'patient_id',
        'created', 
    ];  

    public $timestamps = false;

    //Booking -> BookingComment
    public function clinicBookingComment() {
        return $this->hasMany('App\Models\BookingComment', 'booking_id', 'id');
    }    
    
    //Clinic <- Booking
    public function clinicBooking() {
        return $this->belongsTo('App\Models\Clinic', 'clinic_id', 'id');
    }

    //Booking -> Employee
    public function employeeBooking() {
        return $this->belongsTo('App\Models\Employee', 'employee_id', 'id');
    }    

    //Clinic <- Service
    public function serviceBooking() {
        return $this->belongsTo('App\Models\Service', 'service_id', 'id');
    }

    //User <- Booking
    public function userBooking() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    //Patient <- Booking
    public function patientBooking() {
        return $this->belongsTo('App\Models\Patient', 'patient_id', 'id');
    }

}
