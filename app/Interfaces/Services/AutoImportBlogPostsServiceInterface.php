<?php

namespace App\Interfaces\Services;

use App\Models\BlogPost;

interface AutoImportBlogPostsServiceInterface
{
  /**
   * Create a new blog post.
   *
   * @param array $data
   * @return void
   */
  public function import(): void;
}
