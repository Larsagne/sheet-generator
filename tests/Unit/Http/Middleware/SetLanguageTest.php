<?php

namespace Tests\Unit\Http\Middleware;

use App\Http\Middleware\SetLanguage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tests\TestCase;

class SetLanguageTest extends TestCase
{
    public function test_it_sets_the_language() {
        session()->put('language', 'de');

        (new SetLanguage())->handle(new Request(), function () {
            expect(app()->getLocale())->toBe('de');
            return new Response();
        });
    }
}
