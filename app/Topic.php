<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Todo;
use App\Group;
use App\Category;

class Topic extends Model
{
    //
    public function toods()
    {
        return $this->hasMany(Todo::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'categorize_topic', 'topic_id', 'category_id');
    }
}
