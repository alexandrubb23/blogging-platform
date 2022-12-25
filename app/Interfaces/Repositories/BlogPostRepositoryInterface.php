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
   * Get blog post by external post id.
   *
   * @param int $externalPostId
   * 
   * @return App\Models\BlogPost
   */
  public function getByExternalPostId(int $externalPostId): ?BlogPost;

  /**
   * Get blog post by title.
   *
   * @param string $title
   * 
   * @return App\Models\BlogPost
   */
  public function getByTitle(string $title): ?BlogPost;

  /**
   * Create a new blog post.
   *
   * @param array $post
   * 
   * @return App\Models\BlogPost|bool
   */
  public function create(array $post): BlogPost|bool;

  /**
   * Update a blog post.
   *
   * @param array $post
   * 
   * @return App\Models\BlogPost|bool
   */
  public function update(array $post): BlogPost|bool;
}
