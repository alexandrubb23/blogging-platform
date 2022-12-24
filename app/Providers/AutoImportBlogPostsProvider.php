<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AutoImportBlogPostsService;
use App\Repositories\BlogPostRepository;

class AutoImportBlogPostsProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AutoImportBlogPostsService::class, BlogPostRepository::class);
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
