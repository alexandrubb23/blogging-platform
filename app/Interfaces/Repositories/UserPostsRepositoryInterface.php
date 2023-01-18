<?php

namespace App\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\User;

interface UserPostsRepositoryInterface
{
    /**
     * Get the user's posts.
     *
     * @param User $user
     * @return App\Models\BlogPost
     */
    public function getPosts(User $user): HasMany;
}
