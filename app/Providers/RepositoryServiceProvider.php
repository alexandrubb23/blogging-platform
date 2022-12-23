<?php

namespace App\Providers;

use App\Interfaces\BlogPostRepositoryInterface;
use App\Repositories\BlogPostRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BlogPostRepositoryInterface::class, BlogPostRepository::class);
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
