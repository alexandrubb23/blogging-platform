<?php

namespace App\Interfaces\Repositories;

use App\Models\BlogPost;
use Illuminate\Contracts\Database\Eloquent\Builder;

interface BlogPostRepositoryInterface
{
  /**
   * Get all blog posts.
   *
   * @param string $order
   * 
   * @return \Illuminate\Contracts\Database\Eloquent\Builder
   */
  public function getAll(string $order): Builder;

  /**
   * Create a new blog post.
   *
   * @param array $post
   * 
   * @return BlogPost
   */
  public function create(array $post): BlogPost|bool;
}
