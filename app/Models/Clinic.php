<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinicName','clinicDescription','clinicAddress',
        'clinicNumber', 'birLicense', 'clinicPaymentInfo',
        'clinicMainPhoto','clinicStatus', 'birLicenseExpiry',
        'subscriptionDuration', 'user_id'
    ];  

    public $timestamps = false;

    //Clinic -> Award
    public function clinicGiveAward() {
        return $this->hasMany('App\Models\Award', 'clinic_id', 'id');
    }

    //Clinic -> Booking
    public function clinicBooking() {
        return $this->hasMany('App\Models\Booking', 'clinic_id', 'id');
    }

    //Clinic -> Service
    public function clinicService() {
        return $this->hasMany('App\Models\Service', 'clinic_id', 'id');
    }

    //Clinic -> Employee
    public function clinicEmployee() {
        return $this->hasMany('App\Models\Employee', 'clinic_id', 'id');
    }

    //Clinic -> Patient
    public function clinicPatient() {
        return $this->hasMany('App\Models\Patient', 'clinic_id', 'id');
    }

    //Clinic -> Patient
    public function clinicRating() {
        return $this->hasMany('App\Models\Rating', 'clinic_id', 'id');
    }

    //Clinic -> ClinicNotif 
    public function clinicNotif() {
        return $this->hasMany('App\Models\ClinicNotification', 'clinic_id', 'id');
    }

    //Clinic -> Payment
    public function clinicPayment() {
        return $this->hasMany('App\Models\Payment', 'clinic_id', 'id');
    }    
    
    //Clinic -> User
    public function userClinic() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }     

}
