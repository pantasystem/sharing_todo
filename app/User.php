<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Group;
use App\Todo;
use App\Comment;
use App\Message;
use App\Category;

class User extends Authenticatable
{
    use Notifiable;

    public function groups()
    {
        // 第二引数結合テーブル名
        // 第３引数はリレーションを定義しているモデルの外部キー名で、
        // 一方の第４引数には結合するモデルの外部キー名を渡します。
        return $this->belongsToMany(Group::class, 'members', 'group_id', 'user_id');

        //return $this->belongsToMany(Group::class);
    }

    

    public function todos()
    {
        return $this->hasMany(Todo::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function categoriesUsed()
    {
        return $this->morphMany(Category::class, 'author');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
