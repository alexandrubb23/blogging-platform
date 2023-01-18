<?php

namespace App\Services;

class ValidateApiResponse
{
    /**
     * Validate the response.
     *
     * @param object $response
     * @return boolean
     */
    public static function isValidApiResponse(string $apiUrl, object $response)
    {
        return ApiValidator::validate($apiUrl, $response, [
            'status' => 'required|string|in:ok',
            'articles' => 'required|array'
        ]);
    }

    /**
     * Validate the article.
     *
     * @param object $article
     * @return boolean
     */
    public static function isValidApiArticle(string $apiUrl, object $article)
    {
        return ApiValidator::validate($apiUrl, $article, [
            'id' => 'required|int',
            'title' => 'required|string',
            'description' => 'required|string',
            'publishedAt' => 'required|string'
        ]);
    }
}
