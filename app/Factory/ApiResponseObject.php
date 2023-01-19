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

        $this->setResponseProperties();

        return true;
    }

    /**
     * Set the response properties.
     *
     * @return void
     */
    private function setResponseProperties()
    {
        $this->status = $this->response->status;
        $this->articles = $this->response->articles;
    }
}
