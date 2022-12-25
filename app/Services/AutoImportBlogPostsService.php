<?php

namespace App\Services;

use App\Interfaces\Services\AutoImportBlogPostsServiceInterface;
use App\Models\BlogPost;
use Illuminate\Foundation\Inspiring;
use App\Repositories\BlogPostRepository;

class AutoImportBlogPostsService implements AutoImportBlogPostsServiceInterface
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
     * @inheritdoc
     */
    public function import(): BlogPost|false
    {
        return $this->blogPostRepository->create([
            'title' => strip_tags(Inspiring::quote()),
            'description' => 'This is a test post.',
            'user_id' => 21
        ]);
    }
}
