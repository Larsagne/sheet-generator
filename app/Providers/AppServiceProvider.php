<?php

namespace App\Providers;

use App\Contracts\Services\KeyServiceInterface;
use App\Services\KeyService;
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
        $this->app->singleton(KeyServiceInterface::class, function () {
            return new KeyService();
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
