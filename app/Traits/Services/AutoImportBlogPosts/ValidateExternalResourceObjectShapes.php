<?php

namespace App\Traits\Services\AutoImportBlogPosts;

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
    public function isValidResponse(string $api_url, object $response)
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
     * @param [object] $data
     * @param [array] $rules
     * @return void
     */
    private function validate(string $api_url, object $data, array $rules)
    {
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
