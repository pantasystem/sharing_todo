<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateTodoRequest;
use App\Todo;
use App\Facades\TodoService;
use App\Service\SearchTodoQuery;



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
    

    public function getGroupsTodo($todo_id, $group_id)
    {
        $user = Auth::user();

        return TodoService::loadTodo($user, $todo_id, $group_id);
    }

    public function getMyTodo($todo_id)
    {
        $user = Auth::user();
        return TodoService::loadTodo($user, $todo_id, null);
    }
   

    public function achiveMyTodo($todo_id)
    {
        return TodoService::achiveTodo(Auth::user(), $todo_id, null);
    }

    public function achiveGroupsTodo($group_id, $todo_id)
    {
        return TodoService::achiveTodo(Auth::user(), $todo_id, $group_id);
    }

    

    public function searchTodos(Request $request, $group_id = null)
    {
        //$group_id = $request->input('group_id', null);
        $is_start_match = $this->toBoolean($request->query('start_match', false));
        $is_end_match = $this->toBoolean($request->query('end_match', false));
        $is_detail = $this->toBoolean($request->query('detail'));
        $word = $request->query('word');
        $limit = $request->query('limit', 20);

        $orderBy = $request->query('order', 'desc');
        if(strtolower($orderBy) != 'desc'){
            $orderBy = "asc";
        }

        $searchQuery = new SearchTodoQuery(Auth::user(), $word);
        $searchQuery->is_start_match = $is_start_match;
        $searchQuery->is_end_match = $is_end_match;
        $searchQuery->is_detail = $is_detail;
        $searchQuery->setGroup($group_id);
        return $searchQuery->buildQuery()->orderBy('id', $orderBy)->paginate($limit);        
    }

    private function getTodoQuery($user, $group_id = null)
    {
        if($group_id){
            return $user->groups()->findOrFail($group_id)->todos();
        }else{
            return $user->todos();
        }
    }
    
    private function toBoolean($value){
        return $value !== 'false' && $value;
    }
}
