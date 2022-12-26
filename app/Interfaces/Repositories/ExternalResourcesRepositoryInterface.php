<?php

namespace App\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface ExternalResourcesRepositoryInterface
{
    /**
     * Get all external resources.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getAll(): Collection;
}
