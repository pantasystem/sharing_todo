<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Service\TodoService;
use App\Service\EloquentTodoService;

class TodoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        app()->singleton(TodoService::class, EloquentTodoService::class);
        app()->singleton("TodoService", EloquentTodoService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
    }
}
