<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use App\Group;
use App\User;
use App\GroupInvitation;
use Carbon\Carbon;


class InvitationTest extends TestCase
{
    public function setUp(): void
    {
      parent::setUp();
  
      Artisan::call('migrate:fresh');
  
      $this->seed('DatabaseSeeder');
  
    }

    public function testMakeInvitation()
    {
        $group = Group::find(1);
        $groupMember = $group->members()->first();

        $targetUser = User::where('id', '<>', $groupMember->id)->first();
        
        $invitation = $group->invitations()->create([
            'author_id' => $groupMember->id,
            'invitation_user_id' => $targetUser->id,
            'expiration_date' => null,
            'is_accept' => null,
        ]);

        $this->assertNotNull($invitation);
        $this->assertNotNull($targetUser->invitations()->active(Carbon::now())->first());
    }
}
