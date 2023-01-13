<?php

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

function paginate_collection($collection, int $perPage = 10, array $options = [])
{
  $page = request()->input('page', 1);

  $collection = $collection instanceof Collection ? $collection : Collection::make($collection);

  $options = array_merge($options, [
    'path' => request()->url(),
    'query' => request()->query(),
  ]);

  return new LengthAwarePaginator(
    $collection->forPage($page, $perPage)->values(),
    $collection->count(),
    $perPage,
    $page,
    $options
  );
}
