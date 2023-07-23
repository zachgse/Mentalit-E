<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiveAward extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'clinic_id', 'award_id'
    ];  

    public $timestamps = false;

    //User -> Award
    public function userGiveAward() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    //Clinic -> Award
    public function clinicGiveAward() {
        return $this->belongsTo('App\Models\Clinic', 'clinic_id', 'id');
    }

    public function getAward() {
        return $this->belongsTo('App\Models\Award', 'award_id', 'id');
    }
}
