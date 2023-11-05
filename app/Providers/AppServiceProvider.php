<?php

namespace App\Providers;

use App\Contracts\Services\HarmonyServiceInterface;
use App\Services\HarmonyService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(HarmonyServiceInterface::class, function () {
            return new HarmonyService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
