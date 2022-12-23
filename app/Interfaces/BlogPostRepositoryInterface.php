<?php

namespace App\Interfaces;

use App\Http\Requests\StoreBlogPostRequest;

interface BlogPostRepositoryInterface
{
  public function create(StoreBlogPostRequest $post);
}
