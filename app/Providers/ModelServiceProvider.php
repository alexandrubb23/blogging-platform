<?php

namespace App\Providers;

use App\Interfaces\Services\BlogPostServiceInterface;
use App\Services\BlogPostService;
use Illuminate\Support\ServiceProvider;

class ModelServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BlogPostServiceInterface::class, BlogPostService::class);
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
