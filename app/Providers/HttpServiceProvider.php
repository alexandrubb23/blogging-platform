<?php

namespace App\Providers;

use App\Interfaces\Services\HttpServiceInterface;
use App\Services\HttpService;
use Illuminate\Support\ServiceProvider;

class HttpServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(HttpServiceInterface::class, HttpService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
