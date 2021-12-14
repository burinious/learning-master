<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignmentSolution extends Model
{
    protected $table = "ass_solutions";
    
    protected $fillable = [
    	'assignment_id', 'user_id', 'path', 'size'
    ];
}
