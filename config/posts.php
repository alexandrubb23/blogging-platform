<?php

return [
  /*
    |--------------------------------------------------------------------------
    | Limit Posts Results
    |--------------------------------------------------------------------------
    |
    | This value is will limit the posts result. This value is used when the
    | framework needs to list our blog posts.
    |
    */

  'limit' => env('POSTS_PER_PAGE', 10),

  /*
    |--------------------------------------------------------------------------
    | Posts Order Type
    |--------------------------------------------------------------------------
    |
    | This value is the order type. This value is used when the
    | framework needs to list and order desc or asc our blog posts.
    |
    */

  'order_data' =>  match (request()->get('order')) {
    'asc' => 'asc',
    'desc' => 'desc',
    default => 'desc',
  },

  /*
    |--------------------------------------------------------------------------
    | Posts Limit Description
    |--------------------------------------------------------------------------
    |
    |This value is used when the
    | post should nit display the entiry description.
    |
    */

  'limit_description' => 20,
];
