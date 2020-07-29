<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Group;
use App\User;

class Message extends Model
{
    //
    protected $fillable = [
        'text', 'group_id', 'author_id'
    ];

    public function group()
    {
        return $this->belongsTo(Grouop::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }
}
