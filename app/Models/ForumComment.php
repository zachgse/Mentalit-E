<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','forum_id','forumCommentContent',
        'dateTime',
    ];  

    public $timestamps = false;

    //User <- Forum
    public function userForumComment() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    //Forum <- Forum Comment
    public function forumAndComment() {
        return $this->belongsTo('App\Models\Forum', 'forum_id', 'id');
    }

    //Warning -> ForumComment
    public function forumCommentWarning() {
        return $this->hasMany('App\Models\Warning', 'forum_comment_id', 'id');
    }
}
