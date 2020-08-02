<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GroupInvitation;
use App\Group;
use Carbon\Carbon;

class GroupInvitationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function inviteUser(Request $request, Group $group)
    {

        $member = $group->members()->findOrFail(Auth::user()->id);

        // 招待しようとしているユーザー
        $tagetUser = User::findOrFail($request->input('invitation_user_id'));
        $invitation = $group->invitations()->create([
            'author_id' => $member->id,
            'invitation_user_id' => $targetUser->id,
            'expiration_date' => $request->input('expiration_date'),
        ]);

        return $invitation;
    }

    public function answerInvitation(Request $request, $invitation_id, Group $gruop)
    {
        $is_accept = $request->input("is_accept") == true;

        $user = Auth::user();

        // invitationがアクセスしているユーザーに向けられているものなのかを検証する
        $invitation = $user->invitations()->active(Carbon::now())->findOrFail($invitation_id);

        if($is_accept){
            $group->attach($user->id);
        }

        $invitation->is_accept = $is_accept;
        $invitation->save();

        return $user;

    }
}
