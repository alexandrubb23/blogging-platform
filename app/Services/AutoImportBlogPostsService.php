<?php

namespace App\Services;

use Illuminate\Foundation\Inspiring;

use App\Models\BlogPost;
use App\Repositories\BlogPostRepository;
use App\Interfaces\Repositories\BlogPostRepositoryInterface;
use App\Interfaces\Services\AutoImportBlogPostsServiceInterface;

class AutoImportBlogPostsService implements AutoImportBlogPostsServiceInterface
{
    /**
     * @var BlogPostRepository
     */
    private BlogPostRepository $blogPostRepository;

    /**
     * Class constructor.
     *
     * @param App\Interfaces\Repositories\BlogPostRepositoryInterface $blogPostRepository
     */
    public function __construct(BlogPostRepositoryInterface $blogPostRepository)
    {
        $this->blogPostRepository = $blogPostRepository;
    }

    /**
     * @inheritdoc
     */
    public function import(): BlogPost|false
    {
        return $this->blogPostRepository->create([
            'user_id' => 10,
            'title' => strip_tags(Inspiring::quote()),
            'description' => 'This is a test post.',
            'publishedAt' => getCurrentDateAndTime(),
        ]);
    }
}
