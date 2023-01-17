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
    public static function isValidApiResponse(string $api_url, object $response)
    {
        return ValidatorApiResponse::validate($api_url, $response, [
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
    public static function isValidApiArticle(string $api_url, object $article)
    {
        return ValidatorApiResponse::validate($api_url, $article, [
            'id' => 'required|int',
            'title' => 'required|string',
            'description' => 'required|string',
            'publishedAt' => 'required|string'
        ]);
    }
}
