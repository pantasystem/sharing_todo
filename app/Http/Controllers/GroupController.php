<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Request\CreateGroupRequst;
use App\User;
use App\Group;

class GroupController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    

    public function create(CreateGroupRequest $request)
    {
        $user = Auth::user();
        $createdGroup = Group::create($request->only(['name', 'description']));
        $createdGroup->members()->attach($user->id, ['is_admin' => true]);

        return $createdGroup;

    }

   
    public function inviteUser(Request $request, $groupId)
    {

        $group = Group::find($group);
        $member = $group->members()->findOrFail(Auth::user()->id);
        
    }
}
