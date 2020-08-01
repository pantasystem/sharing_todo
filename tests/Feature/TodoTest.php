<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use App\Todo;
use App\User;

class TodoTest extends TestCase
{

    public function setUp(): void
    {
      parent::setUp();
  
      Artisan::call('migrate:fresh');
  
      $this->seed('DatabaseSeeder');
  
    }
    
    public function testFindTodo()
    {
        $todo = Todo::find(1);
        $this->assertNotNull($todo);

    }

    public function testTodosAuthor()
    {
        $todo = Todo::where('author_id','=', 1)
            ->where('group_id','=', 1)->first();
        $this->assertNotNull($todo->author());
        
    }

    public function testTodosGroup()
    {
        $todo = Todo::where('author_id','=', 1)
            ->where('group_id','=', 1)->first();
        $this->assertNotNull($todo->group());
    }

    public function testTodosComment()
    {
        $todo = Todo::where('author_id','=', 1)
            ->where('group_id','=', 1)->first();
        $this->assertNotNull($todo->comments()->first());
    }

    public function testAddAchiever()
    {
        $targetUserId = 1;

        $todo = Todo::where('author_id','=', $targetUserId)
            ->where('group_id','=', 1)->first();
        
        $user = User::find(1);
        $todo->achiever()->associate($user);
        $this->assertNotNull($todo->achiever);
    }

    
}
