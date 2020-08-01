<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Group;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;

class ExampleTest extends TestCase
{

    public function setUp(): void
    {
      parent::setUp();
  
      Artisan::call('migrate:fresh');
  
      $this->seed('DatabaseSeeder');
  
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testBaciTest2()
    {
        $this->assertTrue(Group::find(1) != null);


        $this->assertNotNull(Group::find(1)->members);

        $group = Group::find(1);
        $user = $group->members()->find(1);
        $this->assertNotNull($user);

        $this->assertTrue(!empty($group->todos));
        $this->assertTrue(!empty($user->todos));

    }
}
