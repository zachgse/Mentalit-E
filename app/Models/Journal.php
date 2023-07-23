<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','journalSubject','journalDescription',
        'journalDateTime',
    ];  

    public $timestamps = false;

    //User <- Journal
    public function userJournal() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
