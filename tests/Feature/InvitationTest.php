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

    private $group;
    private $targetUser;
    private $groupMember;

    public function setUp(): void
    {
      parent::setUp();
  
      Artisan::call('migrate:fresh');
  
      $this->seed('DatabaseSeeder');

      $this->group = Group::find(1);

      $this->groupMember = $this->group->members()->first();

      $this->targetUser = User::where('id', '<>', $this->groupMember->id)->first();

  
    }

    public function testMakeInvitation()
    {

        
        $invitation = $this->group->invitations()->create([
            'author_id' => $this->groupMember->id,
            'invitation_user_id' => $this->targetUser->id,
            'expiration_date' => null,
            'is_accept' => null,
        ]);

        $this->assertNotNull($invitation);
        
    }

    public function testScopeActive()
    {
        $invitation = $this->group->invitations()->create([
            'author_id' => $this->groupMember->id,
            'invitation_user_id' => $this->targetUser->id,
            'expiration_date' => null,
            'is_accept' => null,
        ]);

        $this->assertNotNull($this->targetUser->invitations()->active(Carbon::now())->first());
    }

    public function testScopeActiveCaseAcceptTrue()
    {
        $invitation = $this->group->invitations()->create([
            'author_id' => $this->groupMember->id,
            'invitation_user_id' => $this->targetUser->id,
            'expiration_date' => null,
            'is_accept' => true,
        ]);
        $this->assertNull($this->targetUser->invitations()->active(Carbon::now())->first());

    }

    public function testScopeActiveCaseAcceptFalse()
    {
        $invitation = $this->group->invitations()->create([
            'author_id' => $this->groupMember->id,
            'invitation_user_id' => $this->targetUser->id,
            'expiration_date' => null,
            'is_accept' => false,
        ]);
        $this->assertNull($this->targetUser->invitations()->active(Carbon::now())->first());
    }

    public function testScopeActiveCaseExpitationDate()
    {
        $expitationDate = Carbon::now();
        $expitationDate->addDay();
        $invitation = $this->group->invitations()->create([
            'author_id' => $this->groupMember->id,
            'invitation_user_id' => $this->targetUser->id,
            'expiration_date' => $expitationDate,
            'is_accept' => false,
        ]);
        $this->assertNotNull($this->targetUser->invitations()->active(Carbon::now())->first());

    }

    public function testScopeActiveCaseExpired()
    {
        $expitationDate = Carbon::now();
        $expitationDate->subDay();
        $invitation = $this->group->invitations()->create([
            'author_id' => $this->groupMember->id,
            'invitation_user_id' => $this->targetUser->id,
            'expiration_date' => $expitationDate,
            'is_accept' => false,
        ]);
        $this->assertNull($this->targetUser->invitations()->active(Carbon::now())->first());
    }
}
