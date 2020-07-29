<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Todo;
use App\Group;
use App\Category;

/**
 * Topicモデル
 * Topicは作者のものでもあり作者が属しているGroupのものでもある。
 * つまりUserが脱退したりGroupが削除されてもTopicが削除されることはない。
 * 作者、グループどちらかがいれば存在する。
 * Topic 1 : 作者 1, 0
 * Topic 1 : グループ 1, 0
 * TopicはTodoの詳細として利用される。
 */
class Topic extends Model
{
    //
    protected $fillable = [
        'author_id', 'group_id', 'title', 'description'
    ];

    public function toods()
    {
        return $this->hasMany(Todo::class);
    }

    /**
     * 作者のモデルを返す
     */
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
