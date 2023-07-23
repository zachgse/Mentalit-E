<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id','referTo','reason',
        'diagnosis','fileUpload','dateTime',
        'permission',
    ];  

    public $timestamps = false;

    //Booking <- BookingComment
    public function clinicBookingComment() {
        return $this->belongsTo('App\Models\Booking', 'booking_id', 'id');
    }    
}
