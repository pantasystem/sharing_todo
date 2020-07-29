<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Group;
use App\User;

class Message extends Model
{
    //

    public function group()
    {
        return $this->belongsTo(Grouop::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }
}
