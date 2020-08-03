<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateTodoRequest;


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
        $query = $this->getTodoQuery($user, $group_id);

        $query->with('author', 'group', 'categories');
        return $query->paginate($page);

    }

    public function store(CreateTodoRequest $request, $group_id = null)
    {

        $user = Auth::user();

        $query = $this->getTodoQuery($user, $group_id);
        $created = $query->create(
            $request->only('title', 'description')
        );
        $created->author()->associate($user);
        $created->save();

        //$categories = $request->input('categories');

        return $created->load('author', 'group', 'achiever', 'categories');

    }
    public function get($todo_id, $group_id)
    {
        $user = Auth::user();

        return $this->getTodoQuery($user, $group_id)->findOrFail($todo_id);
    }

    public function achiveTodo($todo_id, $group_id)
    {
        $user = Auth::user();
        $todo = $this->getTodoQuery($user, $group_id)->findOrFail($todo_id);
        $todo->associate($user);
        $todo->save();
        return $todo->load('author', 'group', 'achiever', 'categories');
    }

    private function getTodoQuery($user, $group_id = null)
    {
        if($group_id){
            return $user->groups()->findOrFail($group_id)->todos();
        }else{
            return $user->todos();
        }
    }
}
