<?php

namespace App\Factory;

use App\Services\ValidateApiResponse;

class ExternalResponse
{
    public string $status;
    public array $articles;

    /**
     * Factory a response object.
     *
     * @return null|self
     */
    public static function factoryResponse(string $apiUrl, object $externalApiResult): null|self
    {
        if (!ValidateApiResponse::isValidApiResponse($apiUrl, $externalApiResult)) {
            return null;
        }

        $response = new self();

        $response->status = $externalApiResult->status;
        $response->articles = $externalApiResult->articles;

        return $response;
    }
}
