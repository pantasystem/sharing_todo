<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Todo;
use App\Message;

class Group extends Model
{
    //
    public function members()
    {
        //
        // 第二引数結合テーブル名
        // 第３引数はリレーションを定義しているモデルの外部キー名で、
        // 一方の第４引数には結合するモデルの外部キー名を渡します。
        return $this->belongsToMany(User::class, 'members', 'user_id', 'group_id');

    }

    public function todos()
    {
        //return $this->hasMany(Todo:class);
        return $this->hasMany(Todo::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
