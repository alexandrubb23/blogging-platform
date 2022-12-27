<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Log;

use App\Services\HttpService;
use App\Models\ExternalResourcesApi;
use Tests\Helpers\Services\AutoImportBlogPostsHelper;

$response = AutoImportBlogPostsHelper::factoryResponse();

beforeEach(function () use ($response) {
    Log::spy();

    $this->mock(HttpService::class, function ($mock) use ($response) {
        $mock->shouldReceive('getAsObject')->andReturn($response);
    });

    ExternalResourcesApi::factory()->create([
        'api_url' => AutoImportBlogPostsHelper::API_URL
    ]);
});

afterEach(function () use ($response) {
    $response->status = 'ok';
    $response->count = 1;
    $response->articles = [AutoImportBlogPostsHelper::factoryArticle()];

    ExternalResourcesApi::truncate();
});

it('should call logInvalidShapeError and log the error if the status is missing from the response', function () use ($response) {
    unset($response->status);

    AutoImportBlogPostsHelper::importExternalResource();

    $this->assertTrue(true);

    $message = AutoImportBlogPostsHelper::errorMessageInvalidResponseShape($response);
    AutoImportBlogPostsHelper::logErrorHaveBeenCalledWith($message);
});

it('should call logInvalidStatusError and log the error if the status is not equal with ok', function () use ($response) {
    $response->status = 'fail';

    AutoImportBlogPostsHelper::importExternalResource();

    $this->assertTrue(true);

    $message = AutoImportBlogPostsHelper::errorMessageInvalidResponseStatus($response);
    AutoImportBlogPostsHelper::logErrorHaveBeenCalledWith($message);
});

it('should call logInvalidShapeError and log the error if the articles is missing from the response', function () use ($response) {
    unset($response->articles);

    AutoImportBlogPostsHelper::importExternalResource();

    $this->assertTrue(true);

    $message = AutoImportBlogPostsHelper::errorMessageInvalidResponseShape($response);
    AutoImportBlogPostsHelper::logErrorHaveBeenCalledWith($message);
});

it('should call logInvalidArticlesError and log the error if the articles is not an array', function () use ($response) {
    $response->articles = '#';

    AutoImportBlogPostsHelper::importExternalResource();

    $this->assertTrue(true);

    $message = AutoImportBlogPostsHelper::errorMessageInvalidArticlesShape($response);
    AutoImportBlogPostsHelper::logErrorHaveBeenCalledWith($message);
});

it('should call logInvalidArticleShapeError and log the error if the article is missing the id', function () use ($response) {
    unset($response->articles[0]->id);

    AutoImportBlogPostsHelper::importExternalResource();

    $this->assertTrue(true);

    $message = AutoImportBlogPostsHelper::errorMessageInvalidArticleShape($response->articles[0]);
    AutoImportBlogPostsHelper::logErrorHaveBeenCalledWith($message);
});

it('should call logInvalidArticleShapeError and log the error if the article is missing the title', function () use ($response) {
    unset($response->articles[0]->title);

    AutoImportBlogPostsHelper::importExternalResource();

    $this->assertTrue(true);

    $message = AutoImportBlogPostsHelper::errorMessageInvalidArticleShape($response->articles[0]);
    AutoImportBlogPostsHelper::logErrorHaveBeenCalledWith($message);
});

it('should call logInvalidArticleShapeError and log the error if the article is missing the description', function () use ($response) {
    unset($response->articles[0]->description);

    AutoImportBlogPostsHelper::importExternalResource();

    $this->assertTrue(true);

    $message = AutoImportBlogPostsHelper::errorMessageInvalidArticleShape($response->articles[0]);
    AutoImportBlogPostsHelper::logErrorHaveBeenCalledWith($message);
});

it('should call logInvalidArticleShapeError and log the error if the article is missing the publishedAt', function () use ($response) {
    unset($response->articles[0]->publishedAt);

    AutoImportBlogPostsHelper::importExternalResource();

    $this->assertTrue(true);

    $message = AutoImportBlogPostsHelper::errorMessageInvalidArticleShape($response->articles[0]);
    AutoImportBlogPostsHelper::logErrorHaveBeenCalledWith($message);
});

// TODO: Tests Create or update posts....
