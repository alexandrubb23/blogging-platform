<?php

namespace Tests\Helpers\Services;

use Illuminate\Support\Facades\Log;

use App\Services\AutoImportBlogPostsService;

class AutoImportBlogPostsHelper
{
    public const API_URL = 'https://api.square.com';

    /**
     * Factory a response object.
     *
     * @return object
     */
    public static final function factoryResponse(string $status, int $count, string|array $articles): object
    {
        return (object) [
            'count' => $count,
            'status' => $status,
            'articles' => $articles,
        ];
    }

    /**
     * Factory an article object.
     *
     * @return object
     */
    public static final function factoryArticle(int $id, string $title, string $description, string $publishedAt): object
    {
        return (object) [
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'publishedAt' => $publishedAt,
        ];
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
