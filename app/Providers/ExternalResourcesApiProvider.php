<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\ExternalResourcesRepository;
use App\Interfaces\Repositories\ExternalResourcesRepositoryInterface;

class ExternalResourcesApiProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ExternalResourcesRepositoryInterface::class, ExternalResourcesRepository::class);
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
