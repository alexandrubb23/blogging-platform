<?php

namespace App\Factory;

use App\Services\ValidateApiResponse;

class ApiArticleObject extends ApiFactoryObject
{
    public int $id;
    public string $title;
    public string $description;
    public string $publishedAt;

    /**
     * @inheritdoc
     */
    public function isValid(): bool
    {
        if (!ValidateApiResponse::isValidApiArticle($this->apiUrl, $this->response)) {
            return false;
        };

        $this->id = $this->response->id;
        $this->title =  $this->response->title;
        $this->description =  $this->response->description;
        $this->publishedAt =  $this->response->publishedAt;

        return true;
    }
}
