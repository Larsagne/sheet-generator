<?php

namespace App\Http\Middleware;

use App\Enums\Language;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLanguage
{
    public function handle(Request $request, Closure $next): Response
    {
        app()->setLocale(Language::tryFrom(session()->get('language', config('app.locale')))->value);

        return $next($request);
    }
}
