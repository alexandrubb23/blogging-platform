<?php

namespace App\Traits\Services\AutoImportBlogPosts;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

trait ValidateExternalResourceObjectShapes
{

    /**
     * Check if the response is valid.
     *
     * @param object $response
     * @return boolean
     */
    public function isValidResponse(string $api_url, object $response)
    {
        return $this->validate($api_url, $response, [
            'status' => 'required|string|in:ok',
            'articles' => 'required|array'
        ]);
    }

    /**
     * Check if the article is valid.
     *
     * @param object $article
     * @return boolean
     */
    public function isValidArticle(string $api_url, object $article)
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
     * @param [type] $data
     * @param [type] $rules
     * @return void
     */
    private function validate(string $api_url, $data, $rules)
    {
        if (!is_object($data)) return false;

        try {
            Validator::make((array)  $data, $rules)->validate();

            return true;
        } catch (\Throwable $th) {
            Log::error(sprintf('Invalid API "%s" Response', $api_url), [
                'error' => $th->getMessage()
            ]);
        }

        return false;
    }
}
