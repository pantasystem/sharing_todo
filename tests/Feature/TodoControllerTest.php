<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use App\User;
use App\Todo;
use App\Group;

class TodoControllerTest extends TestCase
{
    private $user;

    public function setUp(): void
    {
      parent::setUp();
  
      Artisan::call('migrate:fresh');
  
      $this->seed('DatabaseSeeder');
  
      $this->user = User::find(1);
    }

    public function testGetTodosWhenAuth()
    {
        $aTodo = $this->user->todos()->first();
        $response = $this->actingAs($this->user);
        $response->json('GET', '/api/me/todos')
            ->assertJson([
                'data' => [
                    [
                        'id' => $aTodo->id,
                        'title' => $aTodo->title,
                        'description' => $aTodo->description
                    ]
                ]
            ]);
    }

    public function testGetTodosWhenNotAuth()
    {
        $this->json('GET', '/api/me/todos')
            ->assertStatus(401);

    }

    public function testGetGroupsTodos()
    {
        $aTodo = Group::find(1)->todos()->first();

        $response = $this->actingAs($this->user);
        $response->json('GET', '/api/groups/' .$aTodo->group->id . '/todos')
            ->assertJson([
                'data' => [
                    [
                        'id' => $aTodo->id,
                        'title' => $aTodo->title,
                        'description' => $aTodo->description
                    ]
                ]
            ]);

    }

    public function testGetGroupsTodosNotGroupMember()
    {
        $aTodo = Group::find(1)->todos()->first();

        $notGroupMemberUser = factory(User::class)->make();

        $this->assertNotNull($notGroupMemberUser);

        $response = $this->actingAs($notGroupMemberUser);
        
        $response->json('GET', '/api/groups/' .$aTodo->group->id . '/todos')
            ->assertStatus(404);
    }

    public function testCreateMyTodo()
    {
        $response = $this->actingAs($this->user);

        $testData = [
            'title' => 'Test',
            'description' => 'TestTestDescription'
        ];
        $response = $this->actingAs($this->user);
        $response->json('POST', '/api/me/todos', $testData)->assertJson([
            'title' => $testData['title'],
            'description' => $testData['description'],
            'author' => [
                'id' => $this->user->id,
                'name' => $this->user->name
            ]
        ]);
    }

    public function testCreateTodoOnGroup()
    {
        $response = $this->actingAs($this->user);
        $group = $this->user->groups()->first();

        $testData = [
            'title' => 'Test',
            'description' => 'TestTestDescription'
        ];
        $response = $this->actingAs($this->user);
        $response->json('POST', '/api/groups/'. $group->id . '/todos', $testData)->assertJson([
            'title' => $testData['title'],
            'description' => $testData['description'],
            /*'author' => [
                'id' => $this->user->id,
                'name' => $this->user->name
            ],*/
            'group'=> [
                'name' => $group->name,
                'id' => $group->id
            ]
        ]);
    }

   
}
