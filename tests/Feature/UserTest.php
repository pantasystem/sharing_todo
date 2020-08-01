<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use App\User;

class UserTest extends TestCase
{
    public function setUp(): void
    {
      parent::setUp();
  
      Artisan::call('migrate:fresh');
  
      $this->seed('DatabaseSeeder');
  
    }

    public function testGetUser()
    {
        $user = User::find(1);
        $this->assertNotNull($user);
    }

    public function testGetUsersTodos()
    {
        $user = User::find(1);
        $todo = $user->todos()->first();
        $this->assertNotNull($todo);
    }

    public function testGetUsersGrouop()
    {
        $user = User::find(1);
        $group = $user->groups()->first();
        $this->assertNotNull($group);
    }

    public function testGetUsersComment()
    {
        $user = User::find(1);
        $comment = $user->comments()->first();
        $this->assertNotNull($comment);
    }

    public function testGetUsersUsedCategory()
    {
        $user = User::find(1);
    
        $categoryName = 'TestCategory';

        $category = $user->categoriesUsed()->create([
            'name' => $categoryName
        ]);

        $category = $user->categoriesUsed()->first();
        $this->assertNotNull($category);

        $this->assertTrue($category->name == $categoryName);
    }
}
