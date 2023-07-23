<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'subName','subPrice','subLength',
    ];  

    public $timestamps = false;

    //Payment <- Sub
    public function subPayment() {
        return $this->hasMany('App\Models\Payment', 'subscription_id', 'id');
    }  

}
