<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warning extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id' ,'forum_id','forum_comment_id',
        'description','dateTime', 'category'
    ];  

    public $timestamps = false;

    //User <- Warning
    public function userWarning() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    //Warning -> Forum
    public function forumWarning() {
        return $this->belongsTo('App\Models\Forum', 'forum_id', 'id');
    }

    //Warning -> ForumComment
    public function forumCommentWarning() {
        return $this->belongsTo('App\Models\ForumComment', 'forum_comment_id', 'id');
    }
}
