<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','clinic_id','paymentProof',
        'paymentStatus','paymentDateTime', 'subscription_id'
    ];  

    public $timestamps = false;

    //User <- Payment
    public function userPayment() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }    

    //Clinic <- Payment
    public function clinicPayment() {
        return $this->belongsTo('App\Models\Clinic', 'clinic_id', 'id');
    }    

    //Payment -> Sub
    public function subPayment() {
        return $this->belongsTo('App\Models\Subscription', 'subscription_id', 'id');
    }    
}
