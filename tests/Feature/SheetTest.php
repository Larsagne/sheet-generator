<?php

namespace Tests\Feature;

use App\Models\Sheet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SheetTest extends TestCase
{
    use RefreshDatabase;

    const SHEET = [
        'title' => 'Test Sheet'
    ];

    private User $user;
    private Sheet $existingSheet;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->existingSheet = Sheet::factory()->for($this->user)->create();
    }

    public function test_sheet_listing_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/sheets');

        $response->assertOk();
    }

    public function test_it_can_create_and_redirect_to_edit()
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post('/sheets', self::SHEET);

        $this->assertDatabaseHas('sheets', self::SHEET);

        $sheet = Sheet::where('title', self::SHEET)->first();
        $response->assertStatus(302);
        $response->assertRedirect(route('sheets.edit', ['sheet' => $sheet]));
    }

    public function test_sheet_can_be_updated(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->put(route('sheets.update', ['sheet' => $this->existingSheet->id]), [
                'title' => 'Test User',
                'email' => 'test@example.com',
            ]);

        $response->assertStatus(201);
        $response->assertRedirect('/sheets/' . $this->existingSheet->id . '/edit');
    }

    public function test_it_authorizes_access()
    {
        $ownerUser = User::factory()->create();
        $differentUser = User::factory()->create();
        $existingSheet = Sheet::factory()->create();

        $routes = [
            ['route' => route('sheets.index', null, false), 'method' => 'GET', 'payload' => null],
            ['route' => route('sheets.store', self::SHEET, false), 'method' => 'POST', 'payload' => null],
            ['route' => route('sheets.update', ['sheet' => $existingSheet]), 'method' => 'PUT', 'payload' => null],
            ['route' => route('sheets.delete', ['sheet' => $existingSheet]), 'method' => 'DELETE', 'payload' => null],
            ['route' => route('sheets.show', ['sheet' => $existingSheet]), 'method' => 'GET', 'payload' => null],
            ['route' => route('sheets.pdf', ['sheet' => $existingSheet]), 'method' => 'GET', 'payload' => null],
            ['route' => route('sheets.playback', ['sheet' => $existingSheet]), 'method' => 'GET', 'payload' => null],
            ['route' => route('sheets.edit', ['sheet' => $existingSheet]), 'method' => 'GET', 'payload' => null],
        ];

        foreach ($routes as $route) {
            $response = $this
                ->actingAs($differentUser)
                ->post('/sheets', [
                    'name' => 'Test User',
                    'email' => 'test@example.com',
                ]);
        }
    }
}
