<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','forumSubject','forumComment',
        'dateTime', 'forumCategory'
    ];  

    public $timestamps = false;

    //User <- Forum
    public function userForum() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    //Forum -> Forum Comment
    public function forumAndComment() {
        return $this->hasMany('App\Models\ForumComment', 'forum_id', 'id');
    }

    //Warning -> Forum
    public function forumWarning() {
        return $this->hasMany('App\Models\Warning', 'forum_id', 'id');
    }
}
