<?php

namespace App\Interfaces\Services;

use App\Models\BlogPost;

interface AutoImportBlogPostsServiceInterface
{
  /**
   * Import blog posts from external resources.
   *
   * @return void
   */
  public function import(): void;
}
