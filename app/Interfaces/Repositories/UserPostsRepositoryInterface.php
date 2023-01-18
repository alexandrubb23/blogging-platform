<?php

namespace App\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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

    /**
     * Get the user's posts paginated.
     *
     * @param User $user
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginatedPostsForUser(User $user, int $perPage = 0): LengthAwarePaginator;
}
