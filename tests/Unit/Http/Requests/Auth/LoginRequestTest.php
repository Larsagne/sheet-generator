<?php

namespace Tests\Unit\Http\Requests\Auth;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class LoginRequestTest extends TestCase
{
    public function test_ensure_is_not_rate_limited(): void
    {
        $request = new LoginRequest();

        RateLimiter::shouldReceive('tooManyAttempts')->andReturn(false);
        $this->expectNotToPerformAssertions();

        $request->ensureIsNotRateLimited();
    }

    public function test_ensure_is_rate_limited(): void
    {
        Event::fake();
        $request = new LoginRequest();

        RateLimiter::shouldReceive('tooManyAttempts')->andReturn(true);
        RateLimiter::shouldReceive('availableIn')->andReturn(120);

        $this->expectException(ValidationException::class);
        $request->ensureIsNotRateLimited();
    }
}
