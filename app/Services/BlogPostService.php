<?php

namespace App\Services;

use App\Exceptions\BlogPostCanNotBeCreatedException;
use App\Interfaces\Repositories\BlogPostRepositoryInterface;
use App\Interfaces\Services\BlogPostServiceInterface;
use App\Models\BlogPost;

class BlogPostService implements BlogPostServiceInterface
{
  /**
   * @var BlogPostRepositoryInterface
   */
  private BlogPostRepositoryInterface $blogPostRepository;

  /**
   * Class constructor.
   *
   * @param BlogPostRepositoryInterface $blogPostRepository
   */
  public function __construct(BlogPostRepositoryInterface $blogPostRepository)
  {
    $this->blogPostRepository = $blogPostRepository;
  }

  /**
   * @inheritdoc
   */
  public function create(array $post): BlogPost|false
  {
    try {
      return $this->blogPostRepository->create($post);
    } catch (BlogPostCanNotBeCreatedException $exception) {
      report($exception);
      return false;
    }
  }
}
