<?php

namespace App\Services;

use Illuminate\Foundation\Inspiring;
use App\Services\BlogPostService;

class AutoImportBlogPostsService
{
    /**
     * @var BlogPostService
     */
    private BlogPostService $blogPostService;

    /**
     * Class constructor.
     *
     * @param BlogPostService $blogPostService
     */
    public function __construct(BlogPostService $blogPostService)
    {
        $this->blogPostService = $blogPostService;
    }

    /**
     * Create a new blog post.
     *
     * @param array $data
     * @return string
     */
    public function import(): string
    {
        return $this->blogPostService->create([
            'title' => strip_tags(Inspiring::quote()),
            'description' => 'This is a test post.',
            'user_id' => 21
        ]);
    }
}
