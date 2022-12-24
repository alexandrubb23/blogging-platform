<?php

namespace App\Repositories;

use App\Exceptions\BlogPostCanNotBeCreatedException;
use App\Http\Requests\StoreBlogPostRequest;
use App\Interfaces\Repositories\BlogPostRepositoryInterface;
use App\Models\BlogPost;

class BlogPostRepository implements BlogPostRepositoryInterface
{
  public function create(StoreBlogPostRequest $post)
  {
    try {
      return BlogPost::create([
        'title' => $post->title,
        'description' => $post->description,
        'user_id' => auth()->user()->id,
      ]);
    } catch (\Exception $ex) {
      throw new BlogPostCanNotBeCreatedException('Blog post can not be created.');
    }
  }
}
