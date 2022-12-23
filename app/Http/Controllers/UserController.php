<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function posts()
    {
        $posts = auth()->user()->posts->sortDesc();
        $posts = paginate_collection($posts, 1);

        return view('user.posts', ['posts' => $posts]);
    }
}
