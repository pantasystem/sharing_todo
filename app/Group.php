<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Todo;
use App\Message;

class Group extends Model
{
    //
    public function members()
    {
        return $this->belongsToMany(User::class, 'members', 'user_id', 'group_id');

    }

    public function todos()
    {
        //return $this->hasMany(Todo:class);
    }
}
