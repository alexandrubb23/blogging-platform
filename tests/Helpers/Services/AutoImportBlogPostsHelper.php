<?php

namespace Tests\Helpers\Services;

use stdClass;
use Illuminate\Support\Facades\Log;

use App\Services\AutoImportBlogPostsService;

class AutoImportBlogPostsHelper
{
    public const API_URL = 'https://test.com';

    public static final function factoryResponse(): stdClass
    {
        $response = new stdClass();
        $response->status = 'ok';
        $response->count = 1;
        $response->articles = [AutoImportBlogPostsHelper::factoryArticle()];

        return $response;
    }

    public static final function factoryArticle(): stdClass
    {
        $article = new stdClass();
        $article->title = 'a';
        $article->description = 'b';
        $article->publishedAt = '2021-01-01 00:00:00';

        return $article;
    }

    public static final  function importExternalResource(): void
    {
        app(AutoImportBlogPostsService::class)->import();
    }

    public static final  function errorMessageInvalidResponseShape(object $response): string
    {
        return sprintf(
            'External resource API "%s" returned an invalid shape. Response: %s',
            AutoImportBlogPostsHelper::API_URL,
            json_encode($response)
        );
    }

    public static final  function errorMessageInvalidResponseStatus(object $response): string
    {
        return sprintf(
            'External resource API "%s" returned an invalid status. Response: %s',
            AutoImportBlogPostsHelper::API_URL,
            json_encode($response)
        );
    }

    public static final function errorMessageInvalidArticleShape(object $response): string
    {
        return sprintf(
            'External resource API "%s" returned an invalid article shape. Response: %s',
            AutoImportBlogPostsHelper::API_URL,
            json_encode($response)
        );
    }

    public static final function errorMessageInvalidArticlesShape(object $response): string
    {
        return sprintf(
            'External resource API "%s" returned an invalid articles shape. Response: %s',
            AutoImportBlogPostsHelper::API_URL,
            json_encode($response)
        );
    }

    public static final function logErrorHaveBeenCalledWith(string $message): void
    {
        Log::shouldHaveReceived('error')->once()->with($message);
    }
}
