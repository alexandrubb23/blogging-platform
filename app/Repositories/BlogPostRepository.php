<?php

namespace App\Repositories;

use Illuminate\Contracts\Database\Eloquent\Builder;

use App\Models\BlogPost;
use App\Exceptions\BlogPostCanNotBeCreatedException;
use App\Interfaces\Repositories\BlogPostRepositoryInterface;

class BlogPostRepository implements BlogPostRepositoryInterface
{
  /**
   * @inheritdoc
   */
  public function getAll(string $order): Builder
  {
    return BlogPost::orderBy('created_at', $order);
  }

  /**
   * @inheritdoc
   */
  public function create(array $post): BlogPost|false
  {
    try {
      return $this->createPost($post);
    } catch (BlogPostCanNotBeCreatedException $exception) {
      report($exception);
    }

    return false;
  }

  /**
   * Create a new blog post.
   *
   * @param array $post
   * @return BlogPost
   * @throws BlogPostCanNotBeCreatedException
   */
  private function createPost(array $post): BlogPost
  {
    try {
      return BlogPost::create($post);
    } catch (\Exception $ex) {
      throw new BlogPostCanNotBeCreatedException($ex);
    }
  }
}
