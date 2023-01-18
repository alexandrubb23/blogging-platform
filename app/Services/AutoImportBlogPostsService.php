<?php

namespace App\Services;

use App\Models\BlogPost;
use App\Factory\ExternalArticle;
use App\Factory\ExternalResponse;
use App\Models\ExternalResourcesApi;
use App\Interfaces\Services\HttpServiceInterface;
use App\Interfaces\Repositories\BlogPostRepositoryInterface;
use App\Interfaces\Services\AutoImportBlogPostsServiceInterface;
use App\Interfaces\Repositories\ExternalResourcesRepositoryInterface;

class AutoImportBlogPostsService implements AutoImportBlogPostsServiceInterface
{
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
        $this->externalResourcesRepository->getAll()
            ->each(fn ($externalResource) => $this->importArticlesFromExternalResource($externalResource));
    }

    /**
     * Import articles from external resource.
     * 
     * @param App\Models\ExternalResourcesApi $externalResource
     * @return void
     */
    private function importArticlesFromExternalResource(ExternalResourcesApi $externalResource): void
    {
        $this->externalResource = $externalResource;

        $apiUrl = $this->externalResource->api_url;
        $result = $this->httpService->getAsObject($apiUrl);
        $externalApiResult = ExternalResponse::factoryResponse($apiUrl, $result);

        if (!$externalApiResult) {
            return;
        }

        foreach ($externalApiResult->articles as $externalArticle) {
            $this->importExternalArticle($externalArticle);
        }
    }


    /**
     * Import external article.
     * 
     * @param object $externalArticle
     * @return void
     */
    private function importExternalArticle(object $externalArticle): void
    {
        $externalArticle = ExternalArticle::factoryArticle(
            $this->externalResource->api_url,
            $externalArticle
        );

        if (!$externalArticle) return;

        $this->createOrUpdatePostFromExternalArticle($externalArticle);
    }

    /**
     * Create or update a blog post based on external article.
     * 
     * @param \App\Factory\ExternalArticle $externalArticle
     * @return void
     */
    private function createOrUpdatePostFromExternalArticle(ExternalArticle $externalArticle)
    {
        $post = $this->findPostByTitleOrByExternalId($externalArticle);
        if (!$post) {
            $this->createPostFromExternalArticle($externalArticle);
        } else {
            $this->updatePostFromExternalArticle($post, $externalArticle);
        }
    }

    /**
     * Create a blog post based on external article.
     *
     * @param \App\Factory\ExternalArticle $externalArticle
     * @return boolean|null
     */
    private function createPostFromExternalArticle(ExternalArticle $externalArticle)
    {
        $postData = [
            'title' => $externalArticle->title,
            'user_id' => $this->externalResource->user_id,
            'description' => $externalArticle->description,
            'published_at' => parseISO8601ToDateAndTime($externalArticle->publishedAt),
            'external_post_id' => $this->getExternalPostId($externalArticle->id),
        ];

        $this->blogPostRepository->createPost($postData);
    }

    /**
     * Update a blog post based on external article.
     * 
     * @param \App\Models\BlogPost $post
     * @param \App\Factory\ExternalArticle $externalArticle
     * @return null
     */
    private function updatePostFromExternalArticle(BlogPost $post, ExternalArticle $externalArticle)
    {
        $postData = $this->shouldUpdateBlogPost($post, $externalArticle);
        if ($postData === false) return;

        $this->blogPostRepository->updatePost($postData);
    }

    /**
     * Check if post should be updated.
     * 
     * @param \App\Models\BlogPost $post
     * @param \App\Factory\ExternalArticle $externalArticle
     * @return array|bool
     */
    private function shouldUpdateBlogPost(BlogPost $post, ExternalArticle $externalArticle): array|bool
    {
        $postData = ['id' => $post->id];

        if ($post->title !== $externalArticle->title)
            $postData['title'] = $externalArticle->title;

        if (strip_tags($post->description) !== strip_tags($externalArticle->description))
            $postData['description'] = $externalArticle->description;

        return count($postData) > 1 ? $postData : false;
    }


    /**
     * Find a post by external id.
     * 
     * @param int $externalPostId
     * @return \App\Models\BlogPost|null
     */
    private function findPostByExternalId(int $externalPostId): ?BlogPost
    {
        return $this->blogPostRepository->findByExternalPostId($externalPostId);
    }

    /**
     * Find a post by title or by external id.
     *
     * @param \App\Factory\ExternalArticle $externalArticle
     * @return BlogPost|null
     */
    private function findPostByTitleOrByExternalId(ExternalArticle $externalArticle): ?BlogPost
    {
        $existingPost = $this->blogPostRepository->findByTitle($externalArticle->title);
        if (!$existingPost) {
            $externalPostId = $this->getExternalPostId($externalArticle->id);
            $existingPost = $this->findPostByExternalId($externalPostId);
        }

        return $existingPost;
    }

    /**
     * Compose a unique external post id based on 
     * user_id, api_id and external article id.
     * 
     * @param int $externalPostId
     * @return int
     */
    private function getExternalPostId(int $externalPostId): int
    {
        $userId = $this->externalResource->user_id;
        $resourceId = $this->externalResource->id;

        return $userId . $resourceId . $externalPostId;
    }
}
