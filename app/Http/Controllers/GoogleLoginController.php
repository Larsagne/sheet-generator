<?php

namespace App\Http\Controllers;

use App\Enums\AuthSource;
use App\Providers\RouteServiceProvider;
use Auth;
use Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class GoogleLoginController extends Controller
{
    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(): RedirectResponse
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $user = User::updateOrCreate(
            ['email' => $googleUser->email],
            [
                'name' => $googleUser->name,
                'password' => Hash::make(rand(100000, 999999)),
                'source' => AuthSource::GOOGLE,
            ]
        );

        if ($user->wasRecentlyCreated) {
            event(new Registered($user));
        }

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
