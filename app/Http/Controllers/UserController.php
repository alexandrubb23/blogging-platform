<?php

namespace App\Http\Controllers;

use App\Repositories\UserPostsRepository;
use App\Interfaces\Repositories\UserPostsRepositoryInterface;

class UserController extends Controller
{
    /**
     * @var App\Interfaces\Repositories\UserPostsRepositoryInterface
     */
    private UserPostsRepositoryInterface $userPostsRepository;

    /**
     * Class constructor.
     *
     * @param App\Interfaces\Repositories\UserPostsRepositoryInterface
     */
    public function __construct(UserPostsRepositoryInterface $userPostsRepository)
    {
        $this->userPostsRepository = $userPostsRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function posts()
    {
        $user = auth()->user();
        $posts = $this->userPostsRepository->getPaginatedPostsForUser($user);

        return view('user.posts', compact('posts'));
    }
}
