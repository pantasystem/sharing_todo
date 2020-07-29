<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Group;

class Message extends Model
{
    //

    public function group()
    {
        return $this->belongsTo(Grouop::class);
    }

    public function author()
    {
        
    }
}
