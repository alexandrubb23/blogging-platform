<?php

namespace App\Traits\Services\AutoImportBlogPosts;

trait ValidateExternalResourceObjectShapes
{
    /**
     * Check if the external api result has the expected shape.
     * 
     * @param object $externalApiResult
     * @return bool
     */
    protected function hasValidShape($externalApiResult): bool
    {
        return property_exists($externalApiResult, 'status')
            && property_exists($externalApiResult, 'articles');
    }

    /**
     * Check if the external api articles has the expected shape.
     * 
     * @param object $externalApiResult
     * @return bool
     */
    protected function hasValidArticlesShape(object $article): bool
    {
        return property_exists($article, 'id')
            && property_exists($article, 'title')
            && property_exists($article, 'description');
    }
}
