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
    public function getByExternalPostId(int $externalPostId): ?BlogPost
    {
        return $this->blogPostService->getByExternalPostId($externalPostId);
    }

    /**
     * @inheritdoc
     */
    public function getByTitle(string $title): ?BlogPost
    {
        return $this->blogPostService->getByTitle($title);
    }

    /**
     * @inheritdoc
     */
    public function create(array $post): BlogPost|false
    {
        return $this->blogPostService->create($post);
    }

    /**
     * @inheritdoc
     */
    public function update(array $post): BlogPost|false
    {
        return $this->blogPostService->update($post);
    }
}
