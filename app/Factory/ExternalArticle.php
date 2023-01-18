<?php

namespace App\Factory;

use App\Services\ValidateApiResponse;

class ExternalArticle
{
    public int $id;
    public string $title;
    public string $description;
    public string $publishedAt;

    /**
     * Factory an article object.
     *
     * @return null|self
     */
    public static function factoryArticle(string $apiUrl, object $externalArticle): null|self
    {
        if (!ValidateApiResponse::isValidApiArticle($apiUrl, $externalArticle)) {
            return null;
        };

        $article = new self();

        $article->id = $externalArticle->id;
        $article->title =  $externalArticle->title;
        $article->description =  $externalArticle->description;
        $article->publishedAt =  $externalArticle->publishedAt;

        return $article;
    }
}
