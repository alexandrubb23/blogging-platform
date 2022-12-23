<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogPostRequest;
use App\Models\BlogPost;
use App\Interfaces\BlogPostRepository;
use App\Interfaces\BlogPostRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class BlogPostController extends Controller
{
    /**
     * @var BlogPostRepositoryInterface
     */
    private BlogPostRepositoryInterface $blogPostRepository;

    /**
     * Class constructor.
     *
     * @param BlogPostRepositoryInterface $blogPostRepository
     */
    public function __construct(BlogPostRepositoryInterface $blogPostRepository)
    {
        $this->blogPostRepository = $blogPostRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = request()->get('order');
        if (!in_array($order, config('posts.order_types'))) {
            $order = 'desc';
        }

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
        $status = '-success';

        try {
            $this->blogPostRepository->create($request);
        } catch (\Exception $e) {
            Log::error('Create post error: ' . $e->getMessage());
            $status = '-error';
        } finally {
            return Redirect::route('posts.create')->with('status', 'post-create' . $status);
        }
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
