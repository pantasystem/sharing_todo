<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Comment;

class Todo extends Model
{
    //

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function author()
    {
        // user_idを持つ
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        // group_idを持つ
        return $this->hasMany(User::class);
    }
}
