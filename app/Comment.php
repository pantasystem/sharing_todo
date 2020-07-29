<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Todo;
use App\User;

class Comment extends Model
{
    //

    public function todo()
    {
        return $this->belongsTo(Todo::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class);
    }

    public function replyTo()
    {
        return $this->belongsTo(Comment::class);
    }

    

}
