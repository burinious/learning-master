<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppointmentChat extends Model
{
    protected $table = "appointment_chat";
    
    protected $fillable = [
    	'appointment_id', 'user_id', 'type', 'content'
    ];
}
