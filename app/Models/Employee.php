<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'user_id','clinic_id','prcLicense',
        'accountStatus',
    ];  

    public $timestamps = false;

    use HasFactory;

    //Booking <- Employee
    public function employeeBooking() {
        return $this->hasMany('App\Models\Booking', 'employee_id', 'id');
    }    

    //Employee <- User
    public function userEmployee() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
    
    //Employee <- Clinic
    public function clinicEmployee() {
        return $this->belongsTo('App\Models\Clinic', 'clinic_id', 'id');
    }
}
