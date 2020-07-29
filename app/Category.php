<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Topic;
use App\Group;

class Category extends Model
{
    //

    public function topics()
    {
        return $this->belongsToMany(Topic::class, 'categorize_topic', 'category_id', 'topic_id');
    }

    public function author()
    {
        return $this->morphTo();
    }
}
