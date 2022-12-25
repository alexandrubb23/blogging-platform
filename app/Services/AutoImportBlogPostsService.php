<?php

namespace App\Services;

use App\Repositories\BlogPostRepository;
use App\Interfaces\Repositories\BlogPostRepositoryInterface;
use App\Interfaces\Services\AutoImportBlogPostsServiceInterface;
use App\Interfaces\Services\HttpServiceInterface;
use App\Models\BlogPost;

class AutoImportBlogPostsService implements AutoImportBlogPostsServiceInterface
{
    // TODO: User model
    private $user_id = 10;

    /**
     * @var BlogPostRepository
     */
    private BlogPostRepository $blogPostRepository;

    /**
     * @var HttpServiceInterface
     */
    private HttpServiceInterface $httpService;

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
        // How do we know if the object shape is correct?
        $result = $this->httpService->get('https://candidate-test.sq1.io/api.php')->object();
        if ($result->status !== 'ok') return;

        // What if there are 1000 articles? We don't want to create 1000 queries.
        // What if the article changes his title? We don't want to create a new post. We want to update the existing one, right?
        // But how we know what the title is? We don't have a unique identifier for the article!
        // Possible solution: 
        // - Save the external article id in the database and use it to update the post.
        // -- Look after external article id in the database.
        // --- If exists, compare the title\description. 
        // ---- If the title\description is different, update the post. 
        // ----- If the title\description is the same, do nothing.
        foreach ($result->articles as $article)
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
        if ($existingPost = $this->getPostByExternalId($article->id)) {
            $this->update($article, $existingPost);
            return;
        }

        $titleAlreadyExists = $this->blogPostRepository->getByTitle($article->title);
        if ($titleAlreadyExists) return;

        $this->blogPostRepository->create([
            'title' => $article->title,
            'user_id' => $this->user_id,
            'description' => $article->description,
            'publishedAt' => getCurrentDateAndTime(),
            'external_post_id' => $this->user_id . $article->id,
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
        return $this->blogPostRepository->getByExternalPostId($this->user_id . $externalPostId);
    }
}
