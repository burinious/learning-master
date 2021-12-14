<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignments extends Model
{
    protected $table = "assignments";
    
    protected $fillable = [
    	'student_id', 'tutor_id', 'subject_id', 'title', 'path', 'size'
    ];
}
