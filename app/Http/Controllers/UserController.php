<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function posts()
    {
        $user = auth()->user();
        $posts = $this->getUserPosts($user);

        return view('user.posts', compact('posts'));
    }

    /**
     * Get the user's posts.
     *
     * @param User $user
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    private function getUserPosts(User $user)
    {
        $perPage = config('posts.user_limit_results');
        return $user->posts()->latest()->paginate($perPage);
    }
}
