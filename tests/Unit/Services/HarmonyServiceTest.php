<?php

namespace Tests\Unit\Services;

use App\Enums\Mood;
use App\Enums\RootNote;
use App\Facades\Harmony;
use Tests\TestCase;

class HarmonyServiceTest extends TestCase
{
    public function test_it_returns_available_keys()
    {
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

    public function test_it_validates_chords_correctly()
    {
        $validChords = [
            'C', 'Gm7', 'D#sus4', 'A7', 'Bbadd9', 'Emaj7', 'F#m', 'C#dim', 'Db6', 'Gaug', 'D9', 'Amaj9', 'E7sus4',
            'C#m7b5', 'F#add11', 'Bm6', 'G7b9', 'D#maj13', 'Cmin', 'Gmaj', 'Cm/A', 'G7/B', 'Dmaj7/F#', 'Em7/G', 'A#11'
        ];
        $invalidChords = ['XYZ', '12', 'Hsus4'];

        foreach ($validChords as $chord) {
            $this->assertTrue(Harmony::isValidChord($chord));
        }

        foreach ($invalidChords as $chord) {
            $this->assertFalse(Harmony::isValidChord($chord));
        }
    }
}
