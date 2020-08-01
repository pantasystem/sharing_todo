<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Request\CreateGroupRequst;

class GroupController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    

    public function create(CreateGroupRequest $request)
    {
        $user = Auth::user();

    }

    public function addMember(Request $request, $groupId)
    {
        $user = Auth::user();
        $user->groups()->find($groupId);
    }

}
