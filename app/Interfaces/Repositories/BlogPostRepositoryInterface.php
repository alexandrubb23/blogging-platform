<?php

namespace App\Interfaces\Repositories;

use App\Models\BlogPost;
use Illuminate\Contracts\Database\Eloquent\Builder;

interface BlogPostRepositoryInterface
{
  /**
   * Get all published blog posts.
   * 
   * @return \Illuminate\Contracts\Database\Eloquent\Builder
   */
  public function getAllPublished(): ?Builder;

  /**
   * Find blog post by external post id.
   *
   * @param int $externalPostId
   * 
   * @return App\Models\BlogPost
   */
  public function findByExternalPostId(int $externalPostId): ?BlogPost;

  /**
   * Find blog post by title.
   *
   * @param string $title
   * 
   * @return App\Models\BlogPost
   */
  public function findByTitle(string $title): ?BlogPost;

  /**
   * Create a new blog post.
   *
   * @param array $post
   * 
   * @return App\Models\BlogPost|bool
   */
  public function createPost(array $post): BlogPost|bool;

  /**
   * Update a blog post.
   *
   * @param array $post
   * 
   * @return App\Models\BlogPost|bool
   */
  public function updatePost(array $post): BlogPost|bool;
}
