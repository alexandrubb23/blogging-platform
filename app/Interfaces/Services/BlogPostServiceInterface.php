<?php

namespace App\Interfaces\Services;

use App\Models\BlogPost;

interface BlogPostServiceInterface
{
  /**
   * Create a new blog post.
   *
   * @param array $post
   * 
   * @return BlogPost
   */
  public function create(array $post): BlogPost|bool;
}
