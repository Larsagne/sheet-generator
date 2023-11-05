<?php

namespace Tests\Unit\Services;

use App\Enums\Moods;
use App\Enums\RootNotes;
use App\Facades\Harmony;
use App\Models\User;
use Database\Factories\SheetFactory;
use Tests\TestCase;

class SheetServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_creates_a_sheet_with_all_relations()
    {
        $sheet = SheetFactory::new();
        $keys = Harmony::getKeys();

        $expectedKeys = [
            ['id' => RootNotes::C->name . Moods::Major->name, 'shortName' => RootNotes::C->getShortName() . Moods::Major->getShortName()],
            ['id' => RootNotes::C->name . Moods::Minor->name, 'shortName' => RootNotes::C->getShortName() . Moods::Minor->getShortName()],
            ['id' => RootNotes::CSharp->name . Moods::Major->name, 'shortName' => RootNotes::CSharp->getShortName() . Moods::Major->getShortName()],
            ['id' => RootNotes::CSharp->name . Moods::Minor->name, 'shortName' => RootNotes::CSharp->getShortName() . Moods::Minor->getShortName()],
            ['id' => RootNotes::DFlat->name . Moods::Major->name, 'shortName' => RootNotes::DFlat->getShortName() . Moods::Major->getShortName()],
            ['id' => RootNotes::DFlat->name . Moods::Minor->name, 'shortName' => RootNotes::DFlat->getShortName() . Moods::Minor->getShortName()],
        ];

        foreach ($expectedKeys as $expectedKey) {
            $this->assertContains($expectedKey, $keys);
        }
    }
}
