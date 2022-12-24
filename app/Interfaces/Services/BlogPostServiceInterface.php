<?php

namespace App\Interfaces\Services;

interface BlogPostServiceInterface
{
  /**
   * Create a new blog post.
   *
   * @param array $post
   * 
   * @return string
   */
  public function create(array $post): string;
}
