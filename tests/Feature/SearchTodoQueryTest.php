<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;

use App\User;
use App\Group;
use App\Service\SearchTodoQuery;

class SearchTodoQueryTest extends TestCase
{
    private $user;
    private $query = null;
    private $testWord = 'hogehogeTestWord';

    public function setUp(): void
    {
        parent::setUp();
  
        Artisan::call('migrate:fresh');
  
        $this->seed('DatabaseSeeder');
        $this->user = User::find(1);
        $this->query = new SearchTodoQuery($this->user, $this->testWord);

    }

    public function testNormalSearchByUser()
    {
        $todo = $this->user->todos()->create([
            'title' => 'hoge' . $this->testWord . 'hoge',
            'description' => 'description'
        ]);
        $searchedTodo = $this->query->buildQuery()->first();

        $this->assertNotNull($searchedTodo);

        $this->assertTrue($todo->id == $searchedTodo->id);

    }

    public function testNormalSearchByGroup()
    {
        $group = $this->user->groups()->first();

        $todo = $group->todos()->create([
            'title' => 'hoge' . $this->testWord . 'hoge',
            'description' => 'description'
        ]);

        $this->query->setGroup($this->user, $this->user->groups()->first());

        $searchedTodo = $this->query->buildQuery()->first();

        $this->assertNotNull($searchedTodo);

        $this->assertTrue($todo->id == $searchedTodo->id);
    }

    public function testNotExitSearchByUser()
    {

        $searchedTodo = $this->query->buildQuery()->first();

        $this->assertNull($searchedTodo);
    }

    public function testNotExitSearchByGroup()
    {
        $this->query->setGroup($this->user, $this->user->groups()->first());

        $searchedTodo = $this->query->buildQuery()->first();

        $this->assertNull($searchedTodo);
    }

    public function testHaveNotAccessTodosSearchByUser()
    {
        $group = $this->user->groups()->first();

        $todo = $group->todos()->create([
            'title' => $this->testWord,
            'description' => 'description'
        ]);


        $searchedTodo = $this->query->buildQuery()->first();

        $this->assertNull($searchedTodo);

    }

    public function testOnlyStartMatch()
    {
        $this->query->is_start_match = true;
        $this->query->is_end_match = false;
        $todo = $this->user->todos()->create([
            'title' => 'hogehoge' . $this->testWord,
            'description' => 'description'
        ]);
        $searchedTodo = $this->query->buildQuery()->first();

        $this->assertNotNull($searchedTodo);

        $this->assertTrue($todo->id == $searchedTodo->id);
    }

    public function testOnlyStartMatchCaseNotMatch()
    {
        $this->query->is_start_match = true;
        $this->query->is_end_match = false;
        $todo = $this->user->todos()->create([
            'title' => 'hogehoge' . $this->testWord . 'Hogehoge',
            'description' => 'description'
        ]);
        $searchedTodo = $this->query->buildQuery()->first();

        $this->assertNull($searchedTodo);

    }

    public function testOnlyEndMatch()
    {
        $this->query->is_start_match = false;
        $this->query->is_end_match = true;
        $todo = $this->user->todos()->create([
            'title' => $this->testWord . 'hogehoge',
            'description' => 'description'
        ]);
        $searchedTodo = $this->query->buildQuery()->first();

        $this->assertNotNull($searchedTodo);

        $this->assertTrue($todo->id == $searchedTodo->id);
    }

    public function testOnlyEndMatchCaseNotMatch()
    {
        $this->query->is_start_match = false;
        $this->query->is_end_match = true;
        $todo = $this->user->todos()->create([
            'title' => 'hogehoge' . $this->testWord,
            'description' => 'description'
        ]);
        $searchedTodo = $this->query->buildQuery()->first();

        $this->assertNull($searchedTodo);

    }

    public function testPerfectMatch()
    {
        $todo = $this->user->todos()->create([
            'title' => $this->testWord,
            'description' => 'description'
        ]);

        $this->query->is_start_match = false;
        $this->query->is_end_match = false;

        $searchedTodo = $this->query->buildQuery()->first();

        $this->assertNotNull($searchedTodo);

        $this->assertTrue($todo->id == $searchedTodo->id);
    }

    public function testPerfectMatchCaseNotMatched()
    {
        $todo = $this->user->todos()->create([
            'title' => $this->testWord . 'hoge',
            'description' => 'description'
        ]);

        $this->query->is_start_match = false;
        $this->query->is_end_match = false;

        $searchedTodo = $this->query->buildQuery()->first();

        $this->assertNull($searchedTodo);

    }

    public function testDetailsSearch()
    {
        $todo = $this->user->todos()->create([
            'title' => 'hoge',
            'description' => 'hoge' . $this->testWord . 'hoge'
        ]);

        $this->query->is_detail = true;
        $searchedTodo = $this->query->buildQuery()->first();

        $this->assertNotNull($searchedTodo);

        $this->assertTrue($searchedTodo->id == $todo->id);
    }
}
