<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Log;

use App\Services\HttpService;
use App\Models\ExternalResourcesApi;
use Tests\Helpers\Services\AutoImportPostsHelper;

$response = AutoImportPostsHelper::factoryResponse();

beforeEach(function () use ($response) {
    Log::spy();

    $this->mock(HttpService::class, function ($mock) use ($response) {
        $mock->shouldReceive('getAsObject')->andReturn($response);
    });

    ExternalResourcesApi::factory()->create([
        'api_url' => AutoImportPostsHelper::API_URL
    ]);
});

afterEach(function () use ($response) {
    $response->status = 'ok';
    $response->count = 1;
    $response->articles = [AutoImportPostsHelper::factoryArticle()];

    ExternalResourcesApi::truncate();
});

it('should call logInvalidShapeError and log the error if the status is missing from the response', function () use ($response) {
    unset($response->status);

    AutoImportPostsHelper::importExternalResource();

    $this->assertTrue(true);

    $message = AutoImportPostsHelper::errorMessageInvalidResponseShape($response);
    AutoImportPostsHelper::logErrorHaveBeenCalledWith($message);
});

it('should call logInvalidStatusError and log the error if the status is not equal with ok', function () use ($response) {
    $response->status = 'fail';

    AutoImportPostsHelper::importExternalResource();

    $this->assertTrue(true);

    $message = AutoImportPostsHelper::errorMessageInvalidResponseStatus($response);
    AutoImportPostsHelper::logErrorHaveBeenCalledWith($message);
});

it('should call logInvalidShapeError and log the error if the articles is missing from the response', function () use ($response) {
    unset($response->articles);

    AutoImportPostsHelper::importExternalResource();

    $this->assertTrue(true);

    $message = AutoImportPostsHelper::errorMessageInvalidResponseShape($response);
    AutoImportPostsHelper::logErrorHaveBeenCalledWith($message);
});

it('should call logInvalidArticlesError and log the error if the articles is not an array', function () use ($response) {
    $response->articles = '#';

    AutoImportPostsHelper::importExternalResource();

    $this->assertTrue(true);

    $message = AutoImportPostsHelper::errorMessageInvalidArticlesShape($response);
    AutoImportPostsHelper::logErrorHaveBeenCalledWith($message);
});

it('should call logInvalidArticleShapeError and log the error if the article is missing the id', function () use ($response) {
    unset($response->articles[0]->id);

    AutoImportPostsHelper::importExternalResource();

    $this->assertTrue(true);

    $message = AutoImportPostsHelper::errorMessageInvalidArticleShape($response->articles[0]);
    AutoImportPostsHelper::logErrorHaveBeenCalledWith($message);
});

it('should call logInvalidArticleShapeError and log the error if the article is missing the title', function () use ($response) {
    unset($response->articles[0]->title);

    AutoImportPostsHelper::importExternalResource();

    $this->assertTrue(true);

    $message = AutoImportPostsHelper::errorMessageInvalidArticleShape($response->articles[0]);
    AutoImportPostsHelper::logErrorHaveBeenCalledWith($message);
});

it('should call logInvalidArticleShapeError and log the error if the article is missing the description', function () use ($response) {
    unset($response->articles[0]->description);

    AutoImportPostsHelper::importExternalResource();

    $this->assertTrue(true);

    $message = AutoImportPostsHelper::errorMessageInvalidArticleShape($response->articles[0]);
    AutoImportPostsHelper::logErrorHaveBeenCalledWith($message);
});

it('should call logInvalidArticleShapeError and log the error if the article is missing the publishedAt', function () use ($response) {
    unset($response->articles[0]->publishedAt);

    AutoImportPostsHelper::importExternalResource();

    $this->assertTrue(true);

    $message = AutoImportPostsHelper::errorMessageInvalidArticleShape($response->articles[0]);
    AutoImportPostsHelper::logErrorHaveBeenCalledWith($message);
});

// TODO: Tests Create or update posts....
