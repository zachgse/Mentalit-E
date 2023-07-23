<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_id','notifDescription','notifDateTime',
    ];  

    public $timestamps = false;

    //Clinic <- ClinicNotif 
    public function clinicNotif() {
        return $this->belongsTo('App\Models\Clinic', 'clinic_id', 'id');
    }
}
