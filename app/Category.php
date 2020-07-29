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
        return $this->belongsToMany(Topic::class, 'categories_topic', 'categorie_id', 'topic_id');
    }
}
