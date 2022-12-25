<?php

namespace App\Traits\Services\AutoImportBlogPosts;

trait ValidateExternalResourceObjectShapes
{
    /**
     * The expected shape of the external api result.
     * 
     * @var array
     */
    private $externalResourceShape = [
        'status',
        'articles'
    ];

    /**
     * The expected shape of the external api article.
     * 
     * @var array
     */
    private $articleShape = [
        'id',
        'title',
        'description',
    ];

    /**
     * Check if the external api result has the expected shape.
     * 
     * @param object $result
     * @return bool
     */
    protected function hasValidShape($result): bool
    {
        return $this->propertyExists($this->externalResourceShape, $result);
    }

    /**
     * Check if the external api articles has the expected shape.
     * 
     * @param object $result
     * @return bool
     */
    protected function hasValidArticleShape(object $article): bool
    {
        return $this->propertyExists($this->articleShape, $article);
    }

    /**
     * Check if the external api result has the expected shape.
     * 
     * @param object $result
     * @return bool
     */
    private function propertyExists(array $properties, object $result)
    {
        foreach ($properties as $property)
            if (!property_exists($result, $property)) return false;

        return true;
    }
}
