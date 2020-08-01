<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Group;
use App\GroupInvitationAnswer;

class GroupInvitation extends Model
{
    
    // 招待グループ
    // 招待対象ユーザー
    // 招待有効期限
    // 招待の作成者
    // 承認済みかは他モデルを作成する

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     *  招待対象のユーザー
     * 不特定多数の場合はNullを返す
     */
    public function inviteUser()
    {
        return $this->belongsTo(User::class, 'invite_user');
    }

    public function invitationToTheAnswers()
    {
        return $this->hasMany(GroupInvitationAnswer::class);
    }

    //public function 

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
