<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answers extends Model
{
    protected $table = "answers";
    
    protected $fillable = [
    	'student_id', 'question_id', 'chosen_option', 
    ];
}
