<?php

$order = app()->runningInConsole() === false ? request()->get('order') : 'desc';

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

  'limit_results' => env('POSTS_PER_PAGE', 10),

  /*
    |--------------------------------------------------------------------------
    | Limit User Posts Results
    |--------------------------------------------------------------------------
    |
    | This value is will limit the user posts result. This value is used when the
    | framework needs to list user blog posts.
    |
    */

  'user_limit_results' => env('USER_POSTS_PER_PAGE', 10),

  /*
    |--------------------------------------------------------------------------
    | Posts Order Type
    |--------------------------------------------------------------------------
    |
    | This value is the order type. This value is used when the
    | framework needs to list and order desc or asc our blog posts.
    |
    */

  'order_type' =>  match ($order) {
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

  /*
    |--------------------------------------------------------------------------
    | Posts Date Format
    |--------------------------------------------------------------------------
    |
    | This value is used when the
    | post shows the date when the post was crated.
    |
    */
  'date_format' => 'F jS, Y'
];
