<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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

    /**
     * Get the user's posts paginated.
     *
     * @param User $user
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginatedPostsForUser(User $user, int $perPage = 0): LengthAwarePaginator
    {
        $perPage = $perPage > 0 ? $perPage : config('posts.user_limit_results');
        return $this->getPosts($user)->paginate($perPage);
    }
}
