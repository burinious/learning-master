<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
    protected $table = "appointments";
    
    protected $fillable = [
    	'subject_id', 'tutor_id', 'title', 'content'
    ];
}
