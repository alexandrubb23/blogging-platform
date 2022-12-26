<?php

namespace App\Traits\Services\AutoImportBlogPosts;

use Illuminate\Support\Facades\Log;

trait LogExternalResourceError
{
    /**
     * Log invalid status error.
     * 
     * @param string $api_url
     * @param object $result
     * @return void
     */
    protected function logInvalidStatusError(string $api_url, object $result): void
    {
        $this->logError(sprintf(
            'External resource API "%s" returned an invalid status.',
            $api_url,
        ), $result);
    }

    /**
     * Log invalid shape error.
     * 
     * @param string $api_url
     * @param object $result
     * @return void
     */
    protected function logInvalidShapeError(string $api_url, object $result): void
    {
        $this->logError(sprintf(
            'External resource API "%s" returned an invalid shape.',
            $api_url
        ), $result);
    }

    /**
     * Log invalid articles shape error.
     * 
     * @param string $api_url
     * @param object $result
     * @return void
     */
    protected function logInvalidArticleShapeError(string $api_url, object $article): void
    {
        $this->logError(sprintf(
            'External resource API "%s" returned an invalid article shape.',
            $api_url
        ), $article);
    }

    /**
     * Log external api error.
     * 
     * @param string $api_url
     * @param object $result
     * @return void
     */
    private function logError(string $message, object $result): void
    {
        $message = $message . ' Response: ' . json_encode($result);
        Log::error($message);
    }
}
