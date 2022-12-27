<?php

namespace App\Services;

use App\Models\BlogPost;
use App\Interfaces\Services\HttpServiceInterface;
use App\Interfaces\Repositories\BlogPostRepositoryInterface;
use App\Interfaces\Repositories\ExternalResourcesRepositoryInterface;
use App\Interfaces\Services\AutoImportBlogPostsServiceInterface;
use App\Models\ExternalResourcesApi;
use App\Traits\Services\AutoImportBlogPosts\LogExternalResourceError;
use App\Traits\Services\AutoImportBlogPosts\ValidateExternalResourceObjectShapes;

class AutoImportBlogPostsService implements AutoImportBlogPostsServiceInterface
{
    /**
     * Use utils traits.
     */
    use ValidateExternalResourceObjectShapes, LogExternalResourceError;

    /**
     * @var App\Interfaces\Repositories\BlogPostRepositoryInterface
     */
    private BlogPostRepositoryInterface $blogPostRepository;

    /**
     * @var App\Interfaces\Services\HttpServiceInterface
     */
    private HttpServiceInterface $httpService;

    /**
     * @var App\Models\ExternalResourcesApi
     */
    private ExternalResourcesApi $externalResource;

    /**
     * @var App\Interfaces\Repositories\ExternalResourcesRepositoryInterface
     */
    private ExternalResourcesRepositoryInterface $externalResourcesRepository;

    /**
     * Class constructor.
     *
     * @param App\Interfaces\Repositories\BlogPostRepositoryInterface $blogPostRepository
     * @param App\Interfaces\Services\HttpServiceInterface $httpService
     * @param App\Interfaces\Repositories\ExternalResourcesRepositoryInterface $externalResourcesRepository
     */
    public function __construct(
        BlogPostRepositoryInterface $blogPostRepository,
        HttpServiceInterface $httpService,
        ExternalResourcesRepositoryInterface $externalResourcesRepository
    ) {
        $this->httpService = $httpService;
        $this->blogPostRepository = $blogPostRepository;
        $this->externalResourcesRepository = $externalResourcesRepository;
    }

    /**
     * @inheritdoc
     */
    public final function import(): void
    {
        $externalResources = $this->externalResourcesRepository->getAll();
        foreach ($externalResources as $externalResource)
            $this->importPostsFrom($externalResource);
    }

    /**
     * Import posts from external resource.
     * 
     * @param App\Models\ExternalResourcesApi $externalResource
     * @return void
     */
    private function importPostsFrom(ExternalResourcesApi $externalResource): void
    {
        $this->externalResource = $externalResource;

        $api_url = $this->externalResource->api_url;
        $externalApiResult = $this->httpService->getAsObject($api_url);

        if (!$this->hasValidShape($externalApiResult)) {
            $this->logInvalidShapeError($api_url, $externalApiResult);
            return;
        }

        if ($externalApiResult->status !== 'ok') {
            $this->logInvalidStatusError($api_url, $externalApiResult);
            return;
        }

        foreach ($externalApiResult->articles as $article)
            $this->importExternalPost($article);
    }

    /**
     * Import a single article.
     * 
     * @param object $article
     * @return void
     */
    private function importExternalPost(object $article): void
    {
        if (!$this->hasValidArticleShape($article)) {
            $this->logInvalidArticleShapeError($this->externalResource->api_url, $article);
            return;
        }

        $this->updateOrCreatePost($article);
    }

    /**
     * Create a new blog post.
     * 
     * @param \App\Models\BlogPost $post
     * @return void
     */
    private function updateOrCreatePost(object $article)
    {
        $externalPostId = $this->externalPostId($article->id);
        if ($existingPost = $this->getPostByExternalId($externalPostId)) {
            $this->update($existingPost, $article);
            return;
        }

        $postAlreadyExist = $this->blogPostRepository->getByTitle($article->title);
        if ($postAlreadyExist) return;

        $this->blogPostRepository->create([
            'title' => $article->title,
            'user_id' => $this->externalResource->user_id,
            'description' => $article->description,
            'publishedAt' => getCurrentDateAndTime(),
            'external_post_id' => $externalPostId,
        ]);
    }

    /**
     * Update a blog post.
     * 
     * @param \App\Models\BlogPost $post
     * @return void
     */
    private function update(BlogPost $existingPost, object $article): void
    {
        if ($post = $this->postShouldBeUpdated($existingPost, $article))
            $this->blogPostRepository->update($post);
    }

    /**
     * Check if post should be updated.
     * 
     * @param \App\Models\BlogPost $post
     * @return array|bool
     */
    private function postShouldBeUpdated(BlogPost $existingPost, object $article): array|bool
    {
        $post = ['id' => $existingPost->id];

        if ($existingPost->title !== $article->title)
            $post['title'] = $article->title;

        if (strip_tags($existingPost->description) !== strip_tags($article->description))
            $post['description'] = $article->description;

        return count($post) > 1 ? $post : false;
    }

    /**
     * Post already exists.
     * 
     * @param string $title
     * @return \App\Models\BlogPost|null
     */
    private function getPostByExternalId(int $externalPostId): ?BlogPost
    {
        return $this->blogPostRepository->getByExternalPostId($externalPostId);
    }

    /**
     * Compose a unique external post id based on 
     * user_id, api_id and external article id.
     * 
     * @param string $title
     * @return string
     */
    private function externalPostId(int $externalPostId): int
    {
        return $this->externalResource->user_id . $this->externalResource->id . $externalPostId;
    }
}
