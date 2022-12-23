<?php

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

function paginate_collection($collection, $perPage = 10, $options = [])
{
  $page = request('page') ?: (Paginator::resolveCurrentPage() ?: 1);

  $collection = $collection instanceof Collection ? $collection : Collection::make($collection);

  return new LengthAwarePaginator(
    $collection->forPage($page, $perPage)->values(),
    $collection->count(),
    $perPage,
    $page,
    array_merge($options, ['path' => request()->url()])
  );
}
