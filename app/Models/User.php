<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstName','lastName','middleName',
        'email','password','userType',
        'birthDate','gender','contactNo',
        'zipCode','city','barangay',
        'streetNumber','profile_image','created_at',
        'updated_at','status','consent',
    ];  

    //public $timestamps = false;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //User -> Award
    public function userGiveAward() {
        return $this->hasMany('App\Models\GiveAward', 'user_id', 'id');
    }

    //User -> Booking 
    public function userBooking() {
        return $this->hasMany('App\Models\Booking', 'user_id', 'id');
    }

    //User -> Employee
    public function userEmployee() {
        return $this->hasMany('App\Models\Employee', 'user_id', 'id');
    }

    //User -> Forum
    public function userForum() {
        return $this->hasMany('App\Models\Forum', 'user_id', 'id');
    }

    //User -> Forum Comment
    public function userForumComment() {
        return $this->hasMany('App\Models\ForumComment', 'user_id', 'id');
    }

    //User -> Journal
    public function userJournal() {
        return $this->hasMany('App\Models\Journal', 'user_id', 'id');
    }

    //User -> Log
    public function userLog() {
        return $this->hasMany('App\Models\Log', 'user_id', 'id');
    }

    //User -> Notification
    public function userNotification() {
        return $this->hasMany('App\Models\Notification', 'user_id', 'id');
    }
    
    //User -> Patient
    public function userPatient() {
        return $this->hasMany('App\Models\Patient', 'user_id', 'id');
    }

    //User -> Payment
    public function userPayment() {
        return $this->hasMany('App\Models\Payment', 'user_id', 'id');
    }    

    //User -> Rating
    public function userRating() {
        return $this->hasMany('App\Models\Rating', 'user_id', 'id');
    }

    //User -> Ticket
    public function userTicket() {
        return $this->hasMany('App\Models\Ticket', 'user_id', 'id');
    }

    //Ticket <- Ticket Comment
    public function userTicketComment() {
        return $this->hasMany('App\Models\TicketComment', 'user_id', 'id');
    }

    //Clinic -> User
    public function userClinic() {
        return $this->hasMany('App\Models\Clinic', 'user_id', 'id');
    }     

}
