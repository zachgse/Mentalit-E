<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','ticketSubject','ticketCategory',
        'ticketDescription','ticketStatus','dateTimeIssued',
        'dateTimeUpdated', 'dateTimeResolved', 'file',
    ];  

    public $timestamps = false;

    //User <- Ticket
    public function userTicket() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    //Ticket -> Ticket Comment
    public function ticketComment() {
        return $this->hasMany('App\Models\TicketComment', 'ticket_id', 'id');
    }
}
