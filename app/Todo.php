<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Comment;
use App\Topic;
use App\Category;

/**
 * Todoを表現するモデル
 * 作成者author, 属するグループgroupがある。
 * Todoはauthor, groupどちらかだけで存在することができる。
 * 削除の条件は上位レイヤが決定することとする。
 * また所有者はUser,Groupのポリシーに従うこととする。
 */
class Todo extends Model
{


    protected $fillable = [
        'author_id', 'group_id', 'title', 'description'
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

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'categorize_todos', 'todo_id', 'category_id');
    }

    public function achiever()
    {
        return $this->belongsTo(User::class, 'achiever_id');
    }
}
