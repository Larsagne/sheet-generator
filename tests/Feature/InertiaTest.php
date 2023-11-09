<?php

namespace Tests\Feature;

use Arr;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class InertiaTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_contains_list_of_available_languages()
    {
        $this->get('/')
            ->assertInertia(function (AssertableInertia $page) {
                $page->where('languages.0.value', 'en')
                    ->where('languages.0.label', 'English');
            });
    }

    public function test_it_contains_current_language()
    {
        app()->setLocale('de');

        $this->get('/')
            ->assertInertia(function (AssertableInertia $page) {
                $page->where('language', 'de');
            });
    }

    public function test_it_contains_all_translations()
    {
        app()->setLocale('en');

        $this->get('/')
            ->assertInertia(function (AssertableInertia $page) {
                expect(Arr::get($page->toArray(), 'props.translations'))->toMatchArray([
                    'auth.failed' => 'These credentials do not match our records.'
                ]);
            });
    }
}
