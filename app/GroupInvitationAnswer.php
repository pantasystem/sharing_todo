<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\GroupInvitation;
use App\User;

/**
 * グループ招待のユーザーの反応
 */
class GroupInvitationAnswer extends Model
{
    
    public function invitation()
    {
        return $this->belongsTo(GroupInvitation::class);
    }


    public function answeredUser()
    {
        return $this->belongsTo(User::class);
    }
}
