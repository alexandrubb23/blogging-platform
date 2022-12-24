<?php

namespace App\Interfaces\Repositories;

use App\Models\BlogPost;

interface BlogPostRepositoryInterface
{
  /**
   * Create a new blog post.
   *
   * @param array $post
   * 
   * @return BlogPost
   */
  public function create(array $post): BlogPost;
}
