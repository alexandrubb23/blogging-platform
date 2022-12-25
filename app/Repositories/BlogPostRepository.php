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
   * @inheritdoc
   */
  public function getAll(string $order = 'desc'): Builder
  {
    return BlogPost::orderBy('created_at', $order);
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
}
