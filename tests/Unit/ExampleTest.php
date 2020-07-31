<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\User;
use App\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        //$this->assertTrue(true);
        /*$userData = [
            'name' => 'AName',
            'email' => 'aemail@email.jp',
            'password' => 'secret'
        ];

        $user = new User();
        $user->fill($userData)->save();*/
        //$this->assertDatabaseHas('users', $userData);
        $this->assertTrue(true);
        //$result = DB::table('users')->find(1);
        //$this->assertTrue($result);
    }
}
