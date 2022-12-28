<?php

namespace Tests\Helpers\Services;

use stdClass;
use Illuminate\Support\Facades\Log;

use App\Services\AutoImportBlogPostsService;

class AutoImportBlogPostsHelper
{
    public const API_URL = 'https://test.com';

    /**
     * Factory a response object.
     *
     * @return stdClass
     */
    public static final function factoryResponse(): stdClass
    {
        $response = new stdClass();
        $response->status = 'ok';
        $response->count = 1;
        $response->articles = [AutoImportBlogPostsHelper::factoryArticle()];

        return $response;
    }

    /**
     * Factory an article object.
     *
     * @return stdClass
     */
    public static final function factoryArticle(): stdClass
    {
        $article = new stdClass();
        $article->id = 1;
        $article->title = 'a';
        $article->description = 'b';
        $article->publishedAt = '2021-01-01 00:00:00';

        return $article;
    }

    /**
     * Run the import external resource.
     *
     * @return void
     */
    public static final function importExternalResource(): void
    {
        app(AutoImportBlogPostsService::class)->import();
    }

    /**
     * Log error have been called once with message.
     *
     * @param string $message
     * @return void
     */
    public static final function logErrorHaveBeenCalledOnceWithMessage(string $message): void
    {
        Log::shouldHaveReceived('error')->once()->with(sprintf('Invalid API "%s" Response', self::API_URL), [
            'error' => $message
        ]);
    }

    /**
     * Normalize property name.
     *
     * @param string $field
     * @return string
     */
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
