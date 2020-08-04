<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class TodoService extends Facade
{

    protected static function getFacadeAccessor()
    {
        return "TodoService";
    }
}