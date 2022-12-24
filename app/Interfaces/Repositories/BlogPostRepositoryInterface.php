<?php

namespace App\Interfaces\Repositories;

use App\Http\Requests\StoreBlogPostRequest;

interface BlogPostRepositoryInterface
{
  /**
   * Create a new blog post.
   *
   * @param StoreBlogPostRequest $post
   * 
   * @return void
   */
  public function create(StoreBlogPostRequest $post);
}
