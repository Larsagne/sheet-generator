<?php

namespace Tests\Unit\Enums;

use App\Enums\Language;
use Tests\TestCase;

class LanguageTest extends TestCase
{
    public function test_can_get_associated_language_label() {
        $this->assertEquals('Deutsch', Language::from('de')->label());
    }
}
