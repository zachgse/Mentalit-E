<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','ticket_id','ticketCommentContent',
        'ticketCommentDateTime', 'file',
    ];  

    public $timestamps = false;

    //User <- TicketComment
    public function userTicketComment() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    //Ticket <- Ticket Comment
    public function ticketComment() {
        return $this->belongsTo('App\Models\Ticket', 'ticket_id', 'id');
    }
}
