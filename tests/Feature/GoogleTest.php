<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;

class GoogleTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testHandleGoogleCallback()
    {
        $googleUser = (object) [
            'email' => $this->faker->unique()->safeEmail,
            'name' => $this->faker->name,
        ];

        Socialite::shouldReceive('driver->stateless->user')->andReturn($googleUser);

        $response = $this->get('/auth/google/callback');

        $response->assertStatus(302);
        $response->assertRedirect(route('dashboard'));

        $user = User::where('email', $googleUser->email)->first();
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($googleUser->name, $user->name);
    }
}





