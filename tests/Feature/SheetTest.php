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

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
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
        $response = $this
            ->actingAs($this->user)
            ->post('/sheets', self::SHEET);

        $this->assertDatabaseHas('sheets', self::SHEET);

        $sheet = Sheet::where('title', self::SHEET)->first();
        $response->assertStatus(302);
        $response->assertRedirect(route('sheets.edit', ['sheet' => $sheet]));
    }

    public function test_sheet_can_be_updated(): void
    {
        $sheet = Sheet::factory()->for($this->user)->create(self::SHEET);
        $sheetData = [
            'title' => 'Title 2',
            'artist'
        ];

        $response = $this
            ->actingAs($this->user)
            ->put(route('sheets.update', ['sheet' => $sheet->id]), $sheetData);

        $response->assertStatus(302);
        $response->assertRedirect(route('sheets.edit', ['sheet' => $sheet]));
    }


    public function test_sheet_can_be_deleted(): void
    {
        $sheet = Sheet::factory()->for($this->user)->create(self::SHEET);

        $response = $this
            ->actingAs($this->user)
            ->delete(route('sheets.destroy', ['sheet' => $sheet->id]));

        $response->assertStatus(302);
        $response->assertRedirect(route('sheets.index'));
    }

    // ToDo: Add part/sequence tests from model
}
