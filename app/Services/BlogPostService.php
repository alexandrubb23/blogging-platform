<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Database\Eloquent\Builder;

use App\Models\BlogPost;

class BlogPostService
{
    /**
     * Get all published blog posts.
     * 
     * @return \Illuminate\Contracts\Database\Eloquent\Builder
     */
    public function getAllPublished(): ?Builder
    {
        return BlogPost::whereNotNull('publishedAt');
    }

    /** 
     * @inheritdoc
     */
    public function findByExternalPostId(int $externalPostId): ?BlogPost
    {
        // TODO: We can throw an ModelNotFoundException (BlogPostNotFoundException) here if the post can not be found by external post id.
        return BlogPost::where('external_post_id', $externalPostId)->first();
    }

    /**
     * @inheritdoc
     */
    public function findByTitle(string $title): ?BlogPost
    {
        // TODO: We can throw an ModelNotFoundException (BlogPostNotFoundException) here if the post can not be found by title.
        return BlogPost::where('title', $title)->first();
    }

    /**
     * @inheritdoc
     */
    public function createPost(array $post): BlogPost|false
    {
        try {
            return BlogPost::create($post);
        } catch (Exception $ex) {
            $this->logError(__FUNCTION__, $ex);
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function updatePost(array $post): BlogPost|false
    {
        try {
            $blogPost = BlogPost::find($post['id']);

            $blogPost->fill($post);
            $blogPost->save();

            return $blogPost;
        } catch (Exception $ex) {
            $this->logError(__FUNCTION__, $ex);
        }

        return false;
    }

    /**
     * Log error.
     *
     * @param string $errorMessage
     * @param Exception $ex
     * 
     * @return void
     */
    private function logError(string $action, Exception $ex): void
    {
        $errorMessage = sprintf("%s: %s", $action, $ex->getMessage());
        Log::error($errorMessage);
    }
}
