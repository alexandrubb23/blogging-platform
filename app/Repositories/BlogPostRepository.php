<?php

namespace App\Repositories;

use App\Exceptions\BlogPostCanNotBeCreatedException;
use App\Interfaces\Repositories\BlogPostRepositoryInterface;
use App\Models\BlogPost;

class BlogPostRepository implements BlogPostRepositoryInterface
{
  /**
   * @inheritdoc
   */
  public function create(array $post)
  {
    try {
      return BlogPost::create($post);
    } catch (\Exception $ex) {
      throw new BlogPostCanNotBeCreatedException('Blog post can not be created.');
    }
  }
}
