<?php

namespace App\Traits\Services\AutoImportBlogPosts;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

trait ValidateExternalResourceObjectShapes
{
    /**
     * Validate the response.
     *
     * @param object $response
     * @return boolean
     */
    public function isValidApiResponse(string $api_url, object $response)
    {
        return $this->validate($api_url, $response, [
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
    public function isValidApiArticle(string $api_url, object $article)
    {
        return $this->validate($api_url, $article, [
            'id' => 'required|int',
            'title' => 'required|string',
            'description' => 'required|string',
            'publishedAt' => 'required|string'
        ]);
    }

    /**
     * Validate the data.
     *
     * @param [object] $data
     * @param [array] $rules
     * @return void
     */
    private function validate(string $api_url, object $data, array $rules)
    {
        try {
            Validator::make((array)  $data, $rules)->validate();

            return true;
        } catch (Exception $ex) {
            $this->logError($api_url, $ex);
        }

        return false;
    }

    /**
     * Log error.
     *
     * @param string $errorMessage
     * @param Exception $ex
     * 
     * @return void
     */
    private function logError(string $api_url, Exception $ex): void
    {
        $errorMessage = sprintf('Invalid API "%s" Response: %s', $api_url, $ex->getMessage());
        Log::error($errorMessage);
    }
}
