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
        $article->id = rand(1, 1000);
        $article->title = 'a';
        $article->description = 'b';
        $article->publishedAt = '2021-01-01 00:00:00';

        return $article;
    }

    public static final function importExternalResource(): void
    {
        app(AutoImportBlogPostsService::class)->import();
    }

    public static final function logErrorHaveBeenCalledOnceWithMessage(string $message): void
    {
        Log::shouldHaveReceived('error')->once()->with(sprintf('Invalid API "%s" Response', self::API_URL), [
            'error' => $message
        ]);
    }

    public static final function normalizePropertyName(string $field): string
    {
        $property = $field;

        $chunks = explode(' ', $field);
        if (isset($chunks[1])) {
            $property = $chunks[0] . ucfirst($chunks[1]);
        }

        return $property;
    }
}
