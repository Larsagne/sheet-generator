<?php

namespace Tests\Feature;

use App\Models\Band;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvitationTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_a_user_can_be_invited_to_a_band_by_email(): void
    {
        $band = Band::factory()->create([
            'founder_id' => $this->user->id
        ]);
        $this->post('/invitations', [
            'invitable_type' => $band::class,
            'invitable_id' => $band->id,
            'email' => 'invited_user@example.com',
        ]);

        $this->assertDatabaseHas('invitations', [
            'email' => 'invited_user@example.com',
            'invitable_id' => $band->id,
            'invitable_type' => $band::class,
        ]);

        // Todo: Add notification test
//        $this->assertDatabaseHas('notifications', [
//            'notifiable_id' => $this->user->id,
//            'data' => json_encode(['entity_name' => 'Example Band']),
//        ]);
    }

    public function test_invitation_can_be_deleted(): void
    {
        /** @var Band $band */
        $band = Band::factory()->create([
            'founder_id' => $this->user->id
        ]);

        /** @var Invitation $invitation */
        $invitation = Invitation::factory()->create([
            'invitable_id' => $band->id,
            'invitable_type' => Band::class,
            'email' => 'invite@test.de',
        ]);

        $this->delete('/invitations/' . $invitation->id);
        $this->assertDatabaseMissing('invitations', [
            'email' => 'invite@test.de',
            'invitable_id' => $band->id,
            'invitable_type' => $band::class,
        ]);
    }
}
