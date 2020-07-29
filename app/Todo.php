<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Comment;
use App\Topic;

class Todo extends Model
{
    //
    protected $fillable = [
        'topic_id', 'author_id', 'group_id'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function author()
    {
        // user_idを持つ
        return $this->belongsTo(User::class, 'author_id');
    }

    public function group()
    {
        // group_idを持つ
        return $this->belongsTo(User::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function achiever()
    {
        return $this->belongsTo(User::class, 'achiever_id');
    }
}
