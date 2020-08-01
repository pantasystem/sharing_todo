<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Group;

class GroupInvitation extends Model
{
    
    // 招待グループ
    // 招待対象ユーザー
    // 招待有効期限
    // 招待の作成者
    // 承認済みかは他モデルを作成する
    // is_accept(招待者の承諾)

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     *  招待対象のユーザー
     */
    public function inviteUser()
    {
        return $this->belongsTo(User::class, 'invite_user');
    }

    //public function 

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
