<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use App\Category;
use App\Group;
use App\User;

class CategoryTest extends TestCase
{

    private $group = null;
    private $user = null;

    public function setUp(): void
    {
      parent::setUp();
  
      Artisan::call('migrate:fresh');
  
      $this->seed('DatabaseSeeder');

      $group = Group::find(1);
      $this->group = $group;

      $this->user = User::find(2);
  
    }

    public function testGroupsCategory()
    {
        $categoryName = 'TestCategory';
        $newGroupCategory = $this->group->categoriesUsed()->create([
            'name' => $categoryName
        ]);

        $createdNote = $newGroupCategory->todos()->create([
            'title' => 'CategorisedTodo1',
            'description' => 'カテゴリー済みTodo'
        ]);

        $this->assertNotNull($newGroupCategory->todos()->first());

        $this->assertNotNull($createdNote->group());

        $this->assertNotNull($newGroupCategory->author());

        $this->assertTrue($newGroupCategory->author_type == Group::class);

        $this->assertTrue($newGroupCategory->author_id == $this->group->id);
    }

    public function testUsersCategory()
    {
        $categoryName = 'TestUserCategory';
        $newUserCategory = $this->user->categoriesUsed()->create([
            'name' => $categoryName
        ]);

        $createdNote = $newUserCategory->todos()->create([
            'title' => 'CategorisedTodo1',
            'description' => 'カテゴリー済みTodo'
        ]);

        $this->assertNotNull($newUserCategory->todos()->first());

        $this->assertNotNull($createdNote->author());

        $this->assertNotNull($newUserCategory->author());

        $this->assertNotNull($newUserCategory->author_type);

        $this->assertTrue($newUserCategory->author_type == User::class);
    }


}
