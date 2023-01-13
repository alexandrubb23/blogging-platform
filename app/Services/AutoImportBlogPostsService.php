<?php

namespace App\Services;

use App\Models\BlogPost;
use App\Interfaces\Services\HttpServiceInterface;
use App\Interfaces\Repositories\BlogPostRepositoryInterface;
use App\Interfaces\Repositories\ExternalResourcesRepositoryInterface;
use App\Interfaces\Services\AutoImportBlogPostsServiceInterface;
use App\Models\ExternalResourcesApi;
use App\Traits\Services\AutoImportBlogPosts\ValidateExternalResourceObjectShapes;

class AutoImportBlogPostsService implements AutoImportBlogPostsServiceInterface
{
    /**
     * Use utils traits.
     */
    use ValidateExternalResourceObjectShapes;

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
            $this->savePostFrom($externalResource);
    }

    /**
     * Import posts from external resource.
     * 
     * @param App\Models\ExternalResourcesApi $externalResource
     * @return void
     */
    private function savePostFrom(ExternalResourcesApi $externalResource): void
    {
        $this->externalResource = $externalResource;

        $api_url = $this->externalResource->api_url;
        $externalApiResult = $this->httpService->getAsObject($api_url);

        if (!$this->isValidApiResponse($api_url, $externalApiResult)) return;

        foreach ($externalApiResult->articles as $post)
            $this->savePost($post);
    }

    /**
     * Import a single post.
     * 
     * @param object $post
     * @return void
     */
    private function savePost(object $post): void
    {
        if (!$this->isValidApiArticle($this->externalResource->api_url, $post)) return;

        $this->createOrUpdatePost($post);
    }

    /**
     * Create a new blog post.
     * 
     * @param \App\Models\BlogPost $post
     * @return void
     */
    private function createOrUpdatePost(object $post)
    {
        $updatePost = $this->updatePost($post);
        if ($updatePost === false) $this->createPost($post);
    }

    /**
     * Create a blog post.
     *
     * @param object $post
     * @return boolean|null
     */
    private function createPost(object $post)
    {
        $postAlreadyExist = $this->blogPostRepository->findByTitle($post->title);
        if ($postAlreadyExist) return false;

        $postData = [
            'title' => $post->title,
            'user_id' => $this->externalResource->user_id,
            'description' => $post->description,
            'publishedAt' => parseISO8601ToDateAndTime($post->publishedAt),
            'external_post_id' => $this->getExternalPostId($post->id),
        ];

        $this->blogPostRepository->createPost($postData);
    }

    /**
     * Update a blog post.
     * 
     * @param \App\Models\BlogPost $post
     * @return boolean|null
     */
    private function updatePost(object $post)
    {
        $externalPostId = $this->getExternalPostId($post->id);

        $existingPost = $this->findPostByExternalId($externalPostId);
        if (!$existingPost) return false;

        $postData = $this->shouldUpdateBlogPost($existingPost, $post);
        if ($postData === false) return;

        $this->blogPostRepository->updatePost($postData);
    }

    /**
     * Check if post should be updated.
     * 
     * @param \App\Models\BlogPost $post
     * @return array|bool
     */
    private function shouldUpdateBlogPost(BlogPost $existingPost, object $post): array|bool
    {
        $postData = ['id' => $existingPost->id];

        if ($existingPost->title !== $post->title)
            $postData['title'] = $post->title;

        if (strip_tags($existingPost->description) !== strip_tags($post->description))
            $postData['description'] = $post->description;

        return count($postData) > 1 ? $postData : false;
    }


    /**
     * Post already exists.
     * 
     * @param string $title
     * @return \App\Models\BlogPost|null
     */
    private function findPostByExternalId(int $externalPostId): ?BlogPost
    {
        return $this->blogPostRepository->findByExternalPostId($externalPostId);
    }

    /**
     * Compose a unique external post id based on 
     * user_id, api_id and external article id.
     * 
     * @param string $title
     * @return string
     */
    private function getExternalPostId(int $externalPostId): int
    {
        return $this->externalResource->user_id . $this->externalResource->id . $externalPostId;
    }
}
