<?php

namespace App\Repositories;

use Illuminate\Contracts\Database\Eloquent\Builder;

use App\Models\BlogPost;
use App\Interfaces\Repositories\BlogPostRepositoryInterface;
use App\Interfaces\Services\BlogPostServiceInterface;
use App\Services\BlogPostService;

class BlogPostRepository implements BlogPostRepositoryInterface
{
    /**
     * Blog post service.
     *
     * @var BlogPostService
     */
    private BlogPostService $blogPostService;

    /**
     * Constructor.
     *
     * @param BlogPostService $blogPostService
     */
    public function __construct(BlogPostService $blogPostService)
    {
        $this->blogPostService = $blogPostService;
    }

    /**
     * @inheritdoc
     */
    public function getAll(string|null $order = 'desc'): ?Builder
    {
        return $this->blogPostService->getAll($order);
    }

    /** 
     * @inheritdoc
     */
    public function findByExternalPostId(int $externalPostId): ?BlogPost
    {
        return $this->blogPostService->findByExternalPostId($externalPostId);
    }

    /**
     * @inheritdoc
     */
    public function findByTitle(string $title): ?BlogPost
    {
        return $this->blogPostService->findByTitle($title);
    }

    /**
     * @inheritdoc
     */
    public function createPost(array $post): BlogPost|false
    {
        return $this->blogPostService->createPost($post);
    }

    /**
     * @inheritdoc
     */
    public function updatePost(array $post): BlogPost|false
    {
        return $this->blogPostService->updatePost($post);
    }
}
