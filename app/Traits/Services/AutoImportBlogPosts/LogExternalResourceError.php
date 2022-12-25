<?php

namespace App\Traits\Services\AutoImportBlogPosts;

use Illuminate\Support\Facades\Log;

trait LogExternalResourceError
{
	protected function logInvalidStatusError(string $apiUrl, object $result): void
	{
		$this->logError(sprintf(
			'External resource API "%s" returned an invalid status.',
			$apiUrl,
		), $result);
	}

	/**
	 * Log invalid shape error.
	 * 
	 * @param object $result
	 * @return void
	 */
	protected function logInvalidShapeError(string $apiUrl, object $result): void
	{
		$this->logError(sprintf(
			'External resource API "%s" returned an invalid shape.',
			$apiUrl
		), $result);
	}

	/**
	 * Log invalid articles shape error.
	 * 
	 * @param object $result
	 * @return void
	 */
	protected function logInvalidArticleShapeError(string $apiUrl, object $article): void
	{
		$this->logError(sprintf(
			'External resource API "%s" returned an invalid article shape.',
			$apiUrl
		), $article);
	}

	/**
	 * Log external api error.
	 * 
	 * @param object $result
	 * @return void
	 */
	private function logError(string $message, object $result): void
	{
		$message = $message . ' Response: ' . json_encode($result);
		Log::error($message);
	}
}
