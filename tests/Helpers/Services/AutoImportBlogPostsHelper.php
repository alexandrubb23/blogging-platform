<?php

namespace Tests\Helpers\Services;

use stdClass;
use Illuminate\Support\Facades\Log;

use App\Services\AutoImportBlogPostsService;

class Article
{
    public int $id;
    public string $title;
    public string $description;
    public string $publishedAt;
}

class Response
{
    public string $status;
    public int $count;
    public string|array $articles;
}

class AutoImportBlogPostsHelper
{
    public const API_URL = 'https://test.com';

    /**
     * Factory a response object.
     *
     * @return Response
     */
    public static final function factoryResponse(string $status, int $count, string|array $articles): Response
    {
        $response = new Response();

        $response->status = $status;
        $response->count = $count;
        $response->articles = $articles;

        return $response;
    }

    /**
     * Factory an article object.
     *
     * @return Article
     */
    public static final function factoryArticle(int $id, string $title, string $description, string $publishedAt): Article
    {
        $article = new Article();

        $article->id = $id;
        $article->title = $title;
        $article->description = $description;
        $article->publishedAt = $publishedAt;

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
        $formattedMessage = sprintf('Invalid API "%s" Response: %s', self::API_URL, $message);
        Log::shouldHaveReceived('error')->once()->with($formattedMessage);
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
