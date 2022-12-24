<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AutoImportBlogPostsService;
use App\Services\BlogPostService;

class AutoImportBlogPostsProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AutoImportBlogPostsService::class, BlogPostService::class);
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
