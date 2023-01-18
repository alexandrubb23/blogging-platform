<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\Repositories\UserPostsRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserPostsRepository implements UserPostsRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function getPosts(User $user): LengthAwarePaginator
    {
        $perPage = config('posts.user_limit_results');
        return $user->posts()->latest()->paginate($perPage);
    }
}
