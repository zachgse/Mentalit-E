<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    use HasFactory;

    protected $fillable = [
        'awardName'
    ];  

    public $timestamps = false;

    public function getAward() {
        return $this->hasMany('App\Models\GiveAward', 'award_id', 'id');
    }

}
