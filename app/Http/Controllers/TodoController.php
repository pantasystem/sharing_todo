<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateTodoRequest;
use App\Todo;
use App\Facades\TodoService;



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

        $query->with('author', 'user', 'group', 'categories');
        return $query->paginate($page);

    }

    public function store(CreateTodoRequest $request, $group_id = null)
    {

        $user = Auth::user();

        //$query = $this->getTodoQuery($user, $group_id);
        $targetQuery;
        if($group_id){
            $targetQuery = $user->groups()->findOrFail($group_id);
        }else{
            $targetQuery = $user;
        }

        $todo = $targetQuery->todos()->create($request->only('title', 'description'));

        $todo->author()->associate($user);
        $todo->save();

        $categories = $request->input('categories');

        if($categories && count($categories)){
            $categoriesUsedQuery = $targetQuery->categoriesUsed();
            foreach($categories as $categoryName){
                $category = $categoriesUsedQuery->where('name', $categoryName)->firstOrCreate([
                    'name' => $categoryName
                ]);
                $category->todos()->attach($todo->id);
                $category->save();

            }
        }
        

        return $todo->load('author', 'group','user', 'achiever', 'categories');

    }
    public function get($todo_id, $group_id)
    {
        $user = Auth::user();

        return $this->getTodoQuery($user, $group_id)->findOrFail($todo_id);
    }

    public function achiveTodo(Request $request)
    {
        $user_id = $request->input('user_id');
        $group_id = $request->input('group_id');
        $user = Auth::user();
        $todo = $this->getTodoQuery($user, $group_id)->findOrFail($todo_id);
        $todo->achiever()->associate($user);
        $todo->save();
        return $todo->load('author', 'group', 'user', 'achiever', 'categories');
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
