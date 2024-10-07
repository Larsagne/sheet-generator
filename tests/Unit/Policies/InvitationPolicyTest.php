<?php

namespace Tests\Unit\Policies;

use App\Models\Band;
use App\Models\User;
use App\Policies\BandPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvitationPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function testView()
    {
        [
            'founder' => $founder,
            'member' => $member,
            'nonMember' => $nonMember,
            'band' => $band
        ] = $this->createDemoBand();
        $policy = new BandPolicy();

        $this->assertTrue($policy->view($founder, $band));
        $this->assertTrue($policy->view($member, $band));
        $this->assertFalse($policy->view($nonMember, $band));
    }

    public function testPdf()
    {
        [
            'founder' => $founder,
            'member' => $member,
            'nonMember' => $nonMember,
            'band' => $band
        ] = $this->createDemoBand();
        $policy = new BandPolicy();

        $this->assertTrue($policy->pdf($founder, $band));
        $this->assertTrue($policy->pdf($member, $band));
        $this->assertFalse($policy->pdf($nonMember, $band));
    }

    public function testPlayback()
    {
        [
            'founder' => $founder,
            'member' => $member,
            'nonMember' => $nonMember,
            'band' => $band
        ] = $this->createDemoBand();
        $policy = new BandPolicy();

        $this->assertTrue($policy->playback($founder, $band));
        $this->assertTrue($policy->playback($member, $band));
        $this->assertFalse($policy->playback($nonMember, $band));
    }

    public function testCreate()
    {
        $user = User::factory()->create();
        $policy = new BandPolicy();

        $this->assertTrue($policy->create($user));
    }

    public function testUpdate()
    {
        [
            'founder' => $founder,
            'member' => $member,
            'nonMember' => $nonMember,
            'band' => $band
        ] = $this->createDemoBand();
        $policy = new BandPolicy();

        $this->assertTrue($policy->update($founder, $band));
        $this->assertTrue($policy->update($member, $band));
        $this->assertFalse($policy->update($nonMember, $band));
    }

    public function testDelete()
    {
        [
            'founder' => $founder,
            'member' => $member,
            'nonMember' => $nonMember,
            'band' => $band
        ] = $this->createDemoBand();
        $policy = new BandPolicy();

        $this->assertTrue($policy->delete($founder, $band));
        $this->assertFalse($policy->delete($member, $band));
        $this->assertFalse($policy->delete($nonMember, $band));
    }

    private function createDemoBand(): array
    {
        $founder = User::factory()->create();
        $member = User::factory()->create();
        $nonMember = User::factory()->create();

        $band = Band::factory()->create(['founder_id' => $founder->id]);
        $band->members()->attach($member);

        return compact('founder', 'member', 'nonMember', 'band');
    }
}
