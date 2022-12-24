<?php

namespace App\Services;

use App\Interfaces\Repositories\BlogPostRepositoryInterface;
use App\Interfaces\Services\BlogPostServiceInterface;

class BlogPostAutoImportService
{
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
     * @inheritdoc
     */
    public function create(array $post): void
    {
        $this->blogPostService->create($post);
    }
}
