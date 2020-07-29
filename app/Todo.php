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

    }

    public function group()
    {
        return $this->hasMany(User::class);
    }
}
