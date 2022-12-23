<?php

namespace App\Repositories;

use App\Http\Requests\StoreBlogPostRequest;
use App\Interfaces\BlogPostRepositoryInterface;
use App\Models\BlogPost;

class BlogPostRepository implements BlogPostRepositoryInterface
{
  public function create(StoreBlogPostRequest $post)
  {
    return BlogPost::create([
      'titlea' => $post->title,
      'description' => $post->description,
      'user_id' => auth()->user()->id,
    ]);
  }
}
