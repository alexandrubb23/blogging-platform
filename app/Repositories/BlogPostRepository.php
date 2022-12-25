<?php

namespace App\Repositories;


use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Database\Eloquent\Builder;

use App\Models\BlogPost;
use App\Interfaces\Repositories\BlogPostRepositoryInterface;

class BlogPostRepository implements BlogPostRepositoryInterface
{
  /**
   * Error message for create method.
   */
  const CREATE_ERROR_MESSAGE = 'Blog post can not be created.';

  /**
   * Error message for update method.
   */
  const UPDATE_ERROR_MESSAGE = 'Blog post can not be updated.';

  /**
   * @inheritdoc
   */
  public function getAll(string $order = 'desc'): Builder
  {
    return BlogPost::orderBy('created_at', $order);
  }

  /** */
  public function getByExternalPostId(int $externalPostId): ?BlogPost
  {
    return BlogPost::where('external_post_id', $externalPostId)->first();
  }

  /**
   * @inheritdoc
   */
  public function getByTitle(string $title): ?BlogPost
  {
    return BlogPost::where('title', $title)->first();
  }

  /**
   * @inheritdoc
   */
  public function create(array $post): BlogPost|false
  {
    try {
      return BlogPost::create($post);
    } catch (Exception $ex) {
      Log::error(self::CREATE_ERROR_MESSAGE, [
        'error' => $ex->getMessage(),
      ]);
    }

    return false;
  }

  /**
   * @inheritdoc
   */
  public function update(array $post): BlogPost|false
  {
    try {
      $blogPost = BlogPost::find($post['id']);

      $blogPost->fill($post);
      $blogPost->save();

      return $blogPost;
    } catch (Exception $ex) {
      Log::error(self::UPDATE_ERROR_MESSAGE, [
        'error' => $ex->getMessage(),
      ]);
    }

    return false;
  }
}
