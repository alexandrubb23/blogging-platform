<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;

use App\Models\BlogPost;
use App\Http\Requests\StoreBlogPostRequest;
use App\Interfaces\Repositories\BlogPostRepositoryInterface;

/**
 * @property App\Interfaces\Repositories\BlogPostRepositoryInterface   $blogPostRepository
 */
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
        $orderBy = 'id'; // TODO: request()->get('order_by', 'created_at')?
        $orderDirection = orderDirection();
        $postsLimit = config('posts.limit_results');

        $posts = $this->blogPostRepository->getAllPublished()
            ->orderBy($orderBy, $orderDirection)
            ->paginate($postsLimit);

        return view('posts.list', ['posts' => $posts]);
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

        $newPost = $this->blogPostRepository->createPost($post);

        return Redirect::route('posts.create')->with('post', $newPost);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(BlogPost $post)
    {
        if (!$post->isPublished) {
            abort(404);
        }

        return view('posts.view', ['post' => $post]);
    }
}
