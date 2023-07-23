<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','notifDescription','notifDateTime',
    ];  

    public $timestamps = false;

    //User <- Notification
    public function userNotification() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
