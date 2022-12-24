<?php

namespace App\Repositories;

use App\Models\BlogPost;
use App\Exceptions\BlogPostCanNotBeCreatedException;
use App\Interfaces\Repositories\BlogPostRepositoryInterface;

class BlogPostRepository implements BlogPostRepositoryInterface
{
  /**
   * @inheritdoc
   */
  public function create(array $post): BlogPost
  {
    try {
      return BlogPost::create($post);
    } catch (\Exception $ex) {
      throw new BlogPostCanNotBeCreatedException();
    }
  }
}
