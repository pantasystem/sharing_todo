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
    

    public function getGroupsTodo($group_id, $todo_id)
    {
        $user = Auth::user();

        return TodoService::loadTodo($user, $todo_id, $group_id)
            ->load('author', 'group','user', 'achiever', 'categories');
    }

    public function getMyTodo($todo_id)
    {
        $user = Auth::user();
        return TodoService::loadTodo($user, $todo_id, null)
            ->load('author', 'group','user', 'achiever', 'categories');
    }
   

    public function achiveMyTodo($todo_id)
    {
        return TodoService::achiveTodo(Auth::user(), $todo_id, null);
    }

    public function achiveGroupsTodo($group_id, $todo_id)
    {
        return TodoService::achiveTodo(Auth::user(), $todo_id, $group_id);
    }

    

    public function todos(Request $request, $group_id = null)
    {
        //$group_id = $request->input('group_id', null);
        $word = $request->query('word');

        $searchQuery = new SearchTodoQuery(Auth::user(), $word);

        $searchQuery->is_start_match  = $this->toBoolean($request->query('start_match', false));
        $searchQuery->is_end_match = $this->toBoolean($request->query('end_match', false));
        $searchQuery->is_detail = $this->toBoolean($request->query('detail'));
        $searchQuery->state = $request->query('state', 0);
        $limit = $request->query('limit', 20);

        $orderBy = $request->query('order', 'asc');
        if(strtolower($orderBy) != 'asc'){
            $orderBy = 'desc';
        }

        $searchQuery->setGroup($group_id);
        return $searchQuery->buildQuery()->orderBy('id', $orderBy)
            ->with('author', 'user', 'group', 'categories')->paginate($limit);        
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
