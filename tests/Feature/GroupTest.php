<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use App\Group;

class GroupTest extends TestCase
{

    public function setUp(): void
    {
      parent::setUp();
  
      Artisan::call('migrate:fresh');
  
      $this->seed('DatabaseSeeder');
  
    }

    public function testFindGroup()
    {
        $group = Group::find(1);
        $this->assertNotNull($group);
    }

    public function testGroupsMember()
    {
        $group = Group::find(1);
        $user = $group->members()->first();
        $this->assertNotNull($user);
    }

    public function testGroupsTodo()
    {
        $group = Group::find(1);
        $todo = $group->todos()->first();
        $this->assertNotNull($todo);
    }

    public function testGroupCategoriseUsed()
    {
        $group = Group::find(1);

        $categoryName = 'GroupCategory';
        $todo = $group->categoriesUsed()->create([
            'name' => $categoryName
        ]);
        $category = $group->categoriesUsed()->where('name', $categoryName)->first();
        $this->assertNotNull($category);
    }
}
