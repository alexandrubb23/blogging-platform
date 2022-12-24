<?php

namespace App\Services;

use Illuminate\Foundation\Inspiring;
use App\Repositories\BlogPostRepository;

class AutoImportBlogPostsService
{
    /**
     * @var BlogPostRepository
     */
    private BlogPostRepository $blogPostRepository;

    /**
     * Class constructor.
     *
     * @param BlogPostRepository $blogPostRepository
     */
    public function __construct(BlogPostRepository $blogPostRepository)
    {
        $this->blogPostRepository = $blogPostRepository;
    }

    /**
     * Create a new blog post.
     *
     * @param array $data
     * @return string
     */
    public function import(): string
    {
        return $this->blogPostRepository->create([
            'title' => strip_tags(Inspiring::quote()),
            'description' => 'This is a test post.',
            'user_id' => 21
        ]);
    }
}
