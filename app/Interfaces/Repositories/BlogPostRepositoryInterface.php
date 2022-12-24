<?php

namespace App\Interfaces\Repositories;

interface BlogPostRepositoryInterface
{
  /**
   * Create a new blog post.
   *
   * @param array $post
   * 
   * @return void
   */
  public function create(array $post);
}
