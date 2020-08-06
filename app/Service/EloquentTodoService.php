<?php

namespace App\Service;

use App\User;

use App\Service\TodoService;

class EloquentTodoService implements TodoService{

    public function achiveTodo(User $user, $todo_id, $group_id)
    {
        $todo = $this->getTodoQuery($user, $group_id)->findOrFail($todo_id);
        $todo->achiever()->associate($user);
        $todo->save();
        return $todo->load('author', 'group', 'user', 'achiever', 'categories');
    }

    public function loadTodo(User $user, $todo_id, $group_id)
    {

        return $this->getTodoQuery($user, $group_id)->findOrFail($todo_id);
    }

    
    public function searchTodos(User $user, $word, $group_id = null)
    {
        $query = getTodoQuery($user, $group_id);
        return $query->where('title', 'like', '%' . $word . '%');
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