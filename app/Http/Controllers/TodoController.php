<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TodoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function todos(Request $request, $page = 1)
    {
        $group_id = $request->input("group_id");

        $user = Auth::user();

        $query;
        if($group_id){
            $query = $user->groups()->findOrFail($group_id)->todos();
        }else{
            $query = $user->todos();
        }

        return $query->paginate($page);

    }

    public function get(Request $request, $todo_id)
    {

    }
}
