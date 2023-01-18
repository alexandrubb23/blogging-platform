<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\User;
use App\Interfaces\Repositories\UserPostsRepositoryInterface;

class UserPostsRepository implements UserPostsRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function getPosts(User $user): HasMany
    {
        return $user->posts()->latest();
    }
}
