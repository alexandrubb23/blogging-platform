<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Database\Eloquent\Builder;

use App\Models\BlogPost;

class BlogPostService
{
    /**
     * Error messages.
     */
    const ACTION_ERRORS = [
        'create' => 'Blog post can not be created.',
        'update' => 'Blog post can not be updated.',
    ];

    /**
     * @inheritdoc
     */
    public function getAll(string|null $order = 'desc'): ?Builder
    {
        $order = match ($order) {
            'asc' => 'asc',
            'desc' => 'desc',
            default => 'desc',
        };

        // TODO: Should we order by publishedAt or should we add a $column parameter to the method?
        return BlogPost::orderBy('id', $order);
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
        Log::error(self::ACTION_ERRORS[$action], [
            'error' => $ex->getMessage(),
        ]);
    }
}
