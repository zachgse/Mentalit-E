<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','clinic_id','booking_id',
        'ratingDescription','starRating','dateTime',
    ];  

    public $timestamps = false;

    //User <- Rating
    public function userRating() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    //Clinic <- Rating
    public function clinicRating() {
        return $this->belongsTo('App\Models\Clinic', 'clinic_id', 'id');
    }

    //Booking <- Rating
    public function bookingRating() {
        return $this->belongsTo('App\Models\Booking', 'booking_id', 'id');
    }    
}
