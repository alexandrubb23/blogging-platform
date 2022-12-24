<?php

namespace App\Services;

use App\Exceptions\BlogPostCanNotBeCreatedException;
use App\Http\Requests\StoreBlogPostRequest;
use App\Interfaces\Repositories\BlogPostRepositoryInterface;
use App\Interfaces\Services\BlogPostServiceInterface;

class BlogPostService implements BlogPostServiceInterface
{
  /**
   * @var string
   */
  private $status = '-success';

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
  public function create(StoreBlogPostRequest $post): string
  {
    try {
      $this->blogPostRepository->create($post);
    } catch (BlogPostCanNotBeCreatedException $exception) {
      report($exception);
      $this->status = '-error';
    }

    return $this->status;
  }
}
