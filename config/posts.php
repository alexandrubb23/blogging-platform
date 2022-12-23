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
    | Posts Order Types
    |--------------------------------------------------------------------------
    |
    | This value is the order types. This value is used when the
    | framework needs to list and order our blog posts.
    |
    */

  'order_types' => ['desc', 'asc'],
];
