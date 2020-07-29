<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Topic;
use App\Group;

/**
 * CategoryはTopicのカテゴリ分けとして利用される。
 * CategoryはTopicと多対多の関係である。
 * 
 */
class Category extends Model
{
    //
    protected $fillable = [
        'name', 'author_id', 'author_type'
    ];

    public function topics()
    {
        return $this->belongsToMany(Topic::class, 'categorize_topic', 'category_id', 'topic_id');
    }

    public function author()
    {
        return $this->morphTo();
    }
}
