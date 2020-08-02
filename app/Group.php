<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Todo;
use App\Message;
use App\Category;
use App\GroupInvitation;

class Group extends Model
{
    //
    protected $fillable = [
        'name', 'description', 'user_id'
    ];

    public function members()
    {
        //
        // 第二引数結合テーブル名
        // 第３引数はリレーションを定義しているモデルの外部キー名で、
        // 一方の第４引数には結合するモデルの外部キー名を渡します。
        return $this->belongsToMany(User::class, 'members', 'group_id', 'user_id');

    }

    public function todos()
    {
        //return $this->hasMany(Todo:class);
        return $this->hasMany(Todo::class);
    }


    public function categoriesUsed()
    {
        return $this->morphMany(Category::class, 'author');
    }

    public function invitations()
    {
        return $this->hasMany(GroupInvitation::class);
    }

    public function activeInvitations()
    {
        return $this->invitations()->whereNull('is_accept');
    }
}
