<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\UserPostsRepository;
use App\Interfaces\Repositories\UserPostsRepositoryInterface;

class UserPostsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserPostsRepositoryInterface::class, UserPostsRepository::class);
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
