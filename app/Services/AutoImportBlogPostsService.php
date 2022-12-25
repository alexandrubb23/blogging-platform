<?php

namespace App\Services;

use App\Models\BlogPost;
use App\Models\ExternalResourcesApi;
use App\Repositories\BlogPostRepository;
use App\Interfaces\Services\HttpServiceInterface;
use App\Interfaces\Repositories\BlogPostRepositoryInterface;
use App\Interfaces\Services\AutoImportBlogPostsServiceInterface;
use App\Traits\Services\AutoImportBlogPosts\LogExternalResourceError;
use App\Traits\Services\AutoImportBlogPosts\ValidateExternalResourceObjectShapes;

class AutoImportBlogPostsService implements AutoImportBlogPostsServiceInterface
{
    /**
     * Use utils traits.
     */
    use ValidateExternalResourceObjectShapes, LogExternalResourceError;

    /**
     * @var App\Repositories\BlogPostRepository
     */
    private BlogPostRepository $blogPostRepository;

    /**
     * @var App\Interfaces\Services\HttpServiceInterface
     */
    private HttpServiceInterface $httpService;

    /**
     * @var App\Models\ExternalResourcesApi
     */
    private ExternalResourcesApi $externalResource;

    /**
     * Class constructor.
     *
     * @param App\Interfaces\Repositories\BlogPostRepositoryInterface $blogPostRepository
     * @param App\Interfaces\Services\HttpServiceInterface $httpService
     */
    public function __construct(
        BlogPostRepositoryInterface $blogPostRepository,
        HttpServiceInterface $httpService
    ) {
        $this->blogPostRepository = $blogPostRepository;
        $this->httpService = $httpService;
    }

    /**
     * @inheritdoc
     */
    public function import(): void
    {
        // TODO: Create a ExternalResourcesApi Repository.
        $externalResources = ExternalResourcesApi::all();

        foreach ($externalResources as $externalResource) {
            $this->externalResource = $externalResource;

            $url = $externalResource->apiUrl;
            $externalApiResult = $this->httpService->getAsObject($url);

            if (!$this->hasValidShape($externalApiResult)) {
                $this->logInvalidShapeError($this->externalResource->apiUrl, $externalApiResult);
                return;
            }

            if ($externalApiResult->status !== 'ok') {
                $this->logInvalidStatusError($this->externalResource->apiUrl, $externalApiResult);
                return;
            }

            foreach ($externalApiResult->articles as $article) {
                if (!$this->hasValidArticleShape($article)) {
                    $this->logInvalidArticleShapeError($this->externalResource->apiUrl, $article);
                    continue;
                }

                $this->updateOrCreatePost($article);
            }
        }
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
            $this->update($article, $existingPost);
            return;
        }

        $post = $this->blogPostRepository->getByTitle($article->title);
        if ($post) return;

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
    private function update(object $article, BlogPost $existingPost)
    {
        $post = ['id' => $existingPost->id];

        if ($existingPost->title !== $article->title)
            $post['title'] = $article->title;

        if (strip_tags($existingPost->description) !== strip_tags($article->description))
            $post['description'] = $article->description;

        if (count($post) > 1)
            $this->blogPostRepository->update($post);
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
