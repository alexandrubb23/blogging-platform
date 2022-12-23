<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogPostRequest;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Redirect;


class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = ['posts' => BlogPost::all()];
        return view('posts.list', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $view = config('routes.posts_create');
        return view($view);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBlogPostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBlogPostRequest $request)
    {

        BlogPost::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->user()->id,
        ]);

        return Redirect::route(config('routes.posts_create'))->with('status', 'post-created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(BlogPost $id)
    {
        $post = ['post' => $id];
        $view = config('routes.post_view');

        return view($view, $post);
    }
}
