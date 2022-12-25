<?php

namespace App\Interfaces\Services;

use App\Models\BlogPost;

interface AutoImportBlogPostsServiceInterface
{
  /**
   * Import blog posts from external resources.
   *
   * @param array $data
   * @return void
   */
  public function import(): void;
}
