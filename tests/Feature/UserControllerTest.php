<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use App\User;

class UserControllerTest extends TestCase
{
    public function setUp(): void
    {
      parent::setUp();
  
      Artisan::call('migrate:fresh');
  
      $this->seed('DatabaseSeeder');
  
    }

    public function testMeAuth()
    {
        $user = User::find(1);
        $response = $this->actingAs($user);

        $response->json('GET', '/api/me')
            ->assertJson([
                'name' => $user->name,
                'id' => $user->id
            ]);
    }

    public function testMeNotAuth()
    {
        $user = User::find(1);

        $this->json('GET', '/api/me')
            ->assertStatus(401);
    }

}
