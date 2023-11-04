<?php

namespace Tests\Feature;

use App\Models\Sheet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SheetTest extends TestCase
{
    use RefreshDatabase;

    public function test_sheet_listing_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/sheets');

        $response->assertOk();
    }

    public function test_sheet_can_be_updated(): void
    {
        $user = User::factory()->create();
        $existingSheet = Sheet::create([
            'title' => 'Test Sheet',
            'description' => 'Test Description',
            'artist' => '',
            'key',
            'duration',
            'tempo',
            'time_signature',
        ]);

        $response = $this
            ->actingAs($user)
            ->post('/sheets', [
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }
}
