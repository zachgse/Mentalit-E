<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_id','serviceName','serviceDescription',
        'servicePrice','serviceLength','serviceStart',
        'serviceEnd',
    ];  

    public $timestamps = false;

    //Clinic -> Service
    public function clinicService() {
        return $this->belongsTo('App\Models\Clinic', 'clinic_id', 'id');
    }

    //Clinic -> Booking
    public function serviceBooking() {
        return $this->hasMany('App\Models\Booking', 'service_id', 'id');
    }

}
