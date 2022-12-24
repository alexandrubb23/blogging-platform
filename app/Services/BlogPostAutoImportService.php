<?php

namespace App\Services;

use App\Interfaces\Repositories\BlogPostRepositoryInterface;

class BlogPostAutoImportService
{
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
     * @inheritdoc
     */
    public function create(array $post): void
    {
        $this->blogPostRepository->create($post);
    }
}
