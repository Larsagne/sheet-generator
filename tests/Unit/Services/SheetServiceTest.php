<?php

namespace Tests\Unit\Services;

use App\Enums\Mood;
use App\Enums\RootNote;
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
        // ToDo: Implement Builder pattern in this service to create a sheet with parts, sequences and measures
        // Should be used in the controller
        $sheet = SheetFactory::new();
        $keys = Harmony::getKeys();

        $expectedKeys = [
            ['id' => RootNote::C->name . Mood::Major->name, 'shortName' => RootNote::C->getShortName() . Mood::Major->getShortName()],
            ['id' => RootNote::C->name . Mood::Minor->name, 'shortName' => RootNote::C->getShortName() . Mood::Minor->getShortName()],
            ['id' => RootNote::CSharp->name . Mood::Major->name, 'shortName' => RootNote::CSharp->getShortName() . Mood::Major->getShortName()],
            ['id' => RootNote::CSharp->name . Mood::Minor->name, 'shortName' => RootNote::CSharp->getShortName() . Mood::Minor->getShortName()],
            ['id' => RootNote::DFlat->name . Mood::Major->name, 'shortName' => RootNote::DFlat->getShortName() . Mood::Major->getShortName()],
            ['id' => RootNote::DFlat->name . Mood::Minor->name, 'shortName' => RootNote::DFlat->getShortName() . Mood::Minor->getShortName()],
        ];

        foreach ($expectedKeys as $expectedKey) {
            $this->assertContains($expectedKey, $keys);
        }
    }
}
