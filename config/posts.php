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
    | Posts Limit Description
    |--------------------------------------------------------------------------
    |
    |This value is used when the
    | post should not display the entiry description.
    |
    */

    'limit_description' => env('POSTS_LIMIT_DESCRIPTION', 20),

    /*
    |--------------------------------------------------------------------------
    | Posts Date Format
    |--------------------------------------------------------------------------
    |
    | This value is used when the
    | post shows the date when the post was crated.
    |
    */
    'date_format' => env('POST_DEFAULT_DATE_FORMAT', 'F jS, Y')
];
