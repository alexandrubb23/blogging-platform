<?php

namespace App\Factory;

use App\Services\ValidateApiResponse;

class ApiResponseObject extends ApiFactoryObject
{
    public string $status;
    public array $articles;

    /**
     * @inheritdoc
     */
    public function isValid(): bool
    {
        if (!ValidateApiResponse::isValidApiResponse($this->apiUrl, $this->response)) {
            return false;
        }

        $this->status = $this->response->status;
        $this->articles = $this->response->articles;

        return true;
    }
}
