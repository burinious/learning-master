<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupMembers extends Model
{
    protected $table = "group_members";
    
    protected $fillable = [
    	'group_id', 'type', 'user_id'
    ];
}
