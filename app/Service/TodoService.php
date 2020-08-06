<?php

namespace App\Service;

use App\User;

interface TodoService{

    public function achiveTodo(User $user, $todo_id, $group_id);

    public function loadTodo(User $user, $todo_id, $group_id);

    public function searchTodos(User $user, $word, $group_id = null);

}