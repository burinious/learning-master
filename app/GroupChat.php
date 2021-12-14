<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupChat extends Model
{
    protected $table = "group_chat";
    
    protected $fillable = [
    	'group_id', 'user_id', 'type', 'content'
    ];
}
