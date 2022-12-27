<?php

namespace Tests\Unit;

use stdClass;
use PHPUnit\Framework\TestCase;

use App\Traits\Services\AutoImportBlogPosts\ValidateExternalResourceObjectShapes;

class ValidateExternalResourceObjectShapesTest extends TestCase
{
    private stdClass $result;

    private object $validateExternalResourceShape;

    protected function setUp(): void
    {
        $this->result = new stdClass();
        $this->validateExternalResourceShape = $this->getObjectForTrait(ValidateExternalResourceObjectShapes::class);
    }

    public function test_external_resource_should_return_true_if_has_a_valid_shape()
    {
        $this->result->status = 'ok';
        $this->result->articles = [];

        $hasValidShape = $this->validateExternalResourceShape->hasValidShape($this->result);

        $this->assertTrue($hasValidShape);
    }

    public function test_external_resource_should_return_false_if_has_an_invalid_shape()
    {
        $hasValidShape = $this->validateExternalResourceShape->hasValidShape($this->result);

        $this->assertFalse($hasValidShape);
    }

    public function test_external_resource_should_return_true_if_article_has_a_valid_shape()
    {
        $this->result->id = 1;
        $this->result->title = 'title';
        $this->result->description = 'description';
        $this->result->publishedAt = '2021-01-01T00:00:00Z';

        $hasValidShape = $this->validateExternalResourceShape->hasValidArticleShape($this->result);

        $this->assertTrue($hasValidShape);
    }

    public function test_external_resource_should_return_false_if_article_is_missing_the_id()
    {
        $this->result->title = 'title';
        $this->result->description = 'description';

        $hasValidShape = $this->validateExternalResourceShape->hasValidArticleShape($this->result);

        $this->assertFalse($hasValidShape);
    }

    public function test_external_resource_should_return_false_if_article_is_missing_the_title()
    {
        $this->result->id = 1;
        $this->result->description = 'description';

        $hasValidShape = $this->validateExternalResourceShape->hasValidArticleShape($this->result);

        $this->assertFalse($hasValidShape);
    }

    public function test_external_resource_should_return_false_if_article_is_missing_the_description()
    {
        $this->result->id = 1;
        $this->result->title = 'title';

        $hasValidShape = $this->validateExternalResourceShape->hasValidArticleShape($this->result);

        $this->assertFalse($hasValidShape);
    }
}
