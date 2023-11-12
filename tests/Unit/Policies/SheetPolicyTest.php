<?php

namespace Tests\Unit\Policies;

use App\Models\Sheet;
use App\Models\User;
use App\Policies\SheetPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SheetPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function testViewAny()
    {
        $user = User::factory()->create();
        $policy = new SheetPolicy();

        $this->assertTrue($policy->viewAny($user));
    }

    public function testView()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $sheet = Sheet::factory()->create(['user_id' => $user->id]);
        $policy = new SheetPolicy();

        $this->assertFalse($policy->view($anotherUser, $sheet));
    }

    public function testPdf()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $sheet = Sheet::factory()->create(['user_id' => $user->id]);
        $policy = new SheetPolicy();

        $this->assertFalse($policy->pdf($anotherUser, $sheet));
    }

    public function testPlayback()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $sheet = Sheet::factory()->create(['user_id' => $user->id]);
        $policy = new SheetPolicy();

        $this->assertFalse($policy->playback($anotherUser, $sheet));
    }

    public function testCreate()
    {
        $user = User::factory()->create();
        $policy = new SheetPolicy();

        $this->assertTrue($policy->create($user));
    }

    public function testUpdate()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $sheet = Sheet::factory()->create(['user_id' => $user->id]);
        $policy = new SheetPolicy();

        $this->assertFalse($policy->update($anotherUser, $sheet));
    }

    public function testDelete()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $sheet = Sheet::factory()->create(['user_id' => $user->id]);
        $policy = new SheetPolicy();

        $this->assertFalse($policy->delete($anotherUser, $sheet));
    }
}
