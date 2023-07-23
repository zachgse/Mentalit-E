<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','clinic_id','created_at',
        'updated_at', 'emergencyName', 'emergencyNumber', 'emergencyAddress',
        'familyHistory','socialHistory',  'medicalHistory',
        'currentMentalState', 'currentMedicalTreatment'
    ];  

    public $timestamps = false;

    //Patient -> Booking
    public function patientBooking() {
        return $this->hasMany('App\Models\Booking', 'patient_id', 'id');
    }

    //User <- Patient
    public function userPatient() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
    
    //Clinic <- Patient
    public function clinicPatient() {
        return $this->belongsTo('App\Models\Clinic', 'clinic_id', 'id');
    }
}
