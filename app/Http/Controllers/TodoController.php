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

    public function todos(Request $request, $group_id = null, $page = 1)
    {
        //$group_id = $request->input("group_id");

        $user = Auth::user();

        \Log::info("access todos");
        $query;
        if($group_id == true){
            $query = $user->groups()->findOrFail($group_id)->todos();
        }else{
            $query = $user->todos();
        }

        $query->with('author', 'group');
        return $query->paginate($page);

    }

    public function get(Request $request, $todo_id)
    {

    }
}
