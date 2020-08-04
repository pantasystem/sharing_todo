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
            ],

        ]);
    }

    public function testCreateTodoOnGroup()
    {
        $response = $this->actingAs($this->user);
        $group = $this->user->groups()->first();

        $categories = ['今日のテスト', '日をまたぐテスト'];

        $testData = [
            'title' => 'Test',
            'description' => 'TestTestDescription',
            'categories' => $categories
        ];

        $categoriesResult = [];

        foreach($categories as $c){
            $categoriesResult[] = [ 'name' => $c ];
        }

        $response = $this->actingAs($this->user);
        $response->json('POST', '/api/groups/'. $group->id . '/todos', $testData)->assertJson([
            'title' => $testData['title'],
            'description' => $testData['description'],
            'author' => [
                'id' => $this->user->id,
                'name' => $this->user->name
            ],
            'categories' => $categoriesResult,
            'group'=> [
                'name' => $group->name,
                'id' => $group->id
            ]
        ]);
    }

    public function testCreateTodoOnGroupCategoryLess()
    {
        $response = $this->actingAs($this->user);
        $group = $this->user->groups()->first();

        $categories = [];

        $testData = [
            'title' => 'Test',
            'description' => 'TestTestDescription',
            'categories' => $categories
        ];

        $categoriesResult = [];

        foreach($categories as $c){
            $categoriesResult[] = [ 'name' => $c ];
        }

        $response = $this->actingAs($this->user);
        $response->json('POST', '/api/groups/'. $group->id . '/todos', $testData)->assertJson([
            'title' => $testData['title'],
            'description' => $testData['description'],
            'author' => [
                'id' => $this->user->id,
                'name' => $this->user->name
            ],
            'categories' => $categoriesResult,
            'group'=> [
                'name' => $group->name,
                'id' => $group->id
            ],
            'user' => null
        ]);
    }

    public function testAchiveTodoInMyTodo()
    {
        $aTodo = $this->user->todos()->first();

        $this->assertNull($aTodo->achiever);
        $response = $this->actingAs($this->user);
        $response->json('PUT', '/api/me/todos/' . $aTodo->id)->assertJson([
            'achiever' => [
                'name' => $this->user->name,
                'id' => $this->user->id
            ]
        ]);

    }

    public function testAchiveTodoInGroup()
    {
        $group = $this->user->groups()->first();
        $this->assertNotNull($group->id);

        $otherMember = factory(User::class)->make();
        $otherMember->save();

        $group->members()->attach($otherMember, ['is_admin' => false]);
        $group->save();

        $aTodo = $otherMember->groups()->findOrFail($group->id)->todos()
            ->create([
                'title' => '他メンバーによる投稿',
                'description' => '他メンバーによるTodoの達成テスト'
            ]);
        $this->assertNotNull($group->todos()->find($aTodo->id));
        $this->assertTrue($aTodo->id == 5);
        $this->assertNotNull($this->user->groups->find(5));
        
            $response = $this->actingAs($this->user);
            $response->json('PUT', '/api/groups/' . $group->id .'/todos/' . $aTodo->id)->assertJson([
                'achiever' => [
                    'name' => $this->user->name,
                    'id' => $this->user->id
                ]
            ]);
    }

   
}
