<?php

namespace App\Interfaces\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

use App\Models\User;

interface UserPostsRepositoryInterface
{
    /**
     * Get the user's posts.
     *
     * @param User $user
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPosts(User $user): LengthAwarePaginator;
}
