<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Request\CreateGroupRequst;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Group;

class GroupController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    

    public function store(CreateGroupRequest $request)
    {
        $user = Auth::user();
        $createdGroup = Group::create($request->only(['name', 'description']));
        $createdGroup->members()->attach($user->id, ['is_admin' => true]);

        return $createdGroup;

    }

    public function get($group_id)
    {
        $user = Auth::user();
        $group = $user->groups()->findOrFail($group_id);

        return $group;
    }

   
    public function members($group_id, $page = 1)
    {
        $user = Auth::user();

        $group = $user->groups()->findOrFail($group_id);

        return $group->members()->paginate($page);
    }
}
