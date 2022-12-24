<?php

namespace App\Interfaces\Services;

use App\Http\Requests\StoreBlogPostRequest;

interface BlogPostServiceInterface
{
  /**
   * Create a new blog post.
   *
   * @param StoreBlogPostRequest $post
   * 
   * @return string
   */
  public function create(StoreBlogPostRequest $post): string;
}
