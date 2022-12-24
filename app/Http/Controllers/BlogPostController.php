<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogPostRequest;
use App\Models\BlogPost;
use App\Interfaces\Repositories\BlogPostRepositoryInterface;
use App\Interfaces\Services\BlogPostServiceInterface;
use Illuminate\Support\Facades\Redirect;

class BlogPostController extends Controller
{
    /**
     * @var BlogPostServiceInterface
     */
    private BlogPostServiceInterface $blogPostService;

    /**
     * Class constructor.
     *
     * @param BlogPostRepositoryInterface $blogPostRepository
     */
    public function __construct(BlogPostServiceInterface $blogPostService)
    {
        $this->blogPostService = $blogPostService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = config('posts.order_data');
        $posts_limit = config('posts.limit');

        $posts = BlogPost::orderBy('created_at', $order)->paginate($posts_limit);

        return view('posts.list', ['posts' =>  $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBlogPostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBlogPostRequest $request)
    {
        $post = [
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->user()->id,
        ];

        $status = $this->blogPostService->create($post);

        return Redirect::route('posts.create')->with('status', 'post-create' . $status);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(BlogPost $id)
    {
        return view('posts.view', ['post' => $id]);
    }
}
