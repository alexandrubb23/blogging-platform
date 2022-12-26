<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

use App\Models\ExternalResourcesApi;
use App\Interfaces\Repositories\ExternalResourcesRepositoryInterface;

class ExternalResourcesRepository implements ExternalResourcesRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function getAll(): Collection
    {
        return ExternalResourcesApi::all();
    }
}
