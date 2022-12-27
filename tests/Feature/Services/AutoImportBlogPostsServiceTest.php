<?php

namespace Tests\Feature;

use stdClass;
use Illuminate\Support\Facades\Log;

use App\Services\HttpService;
use App\Models\ExternalResourcesApi;
use App\Services\AutoImportBlogPostsService;

const API_URL = 'https://test.com';

function factoryResponse(): stdClass
{
    $response = new stdClass();
    $response->status = 'ok';
    $response->count = 1;
    $response->articles = [factoryArticle()];

    return $response;
}

function factoryArticle(): stdClass
{
    $article = new stdClass();
    $article->title = 'a';
    $article->description = 'b';
    $article->publishedAt = '2021-01-01 00:00:00';

    return $article;
}

function importExternalResource(): void
{
    app(AutoImportBlogPostsService::class)->import();
}

function errorMessageInvalidResponseShape(object $response): string
{
    return sprintf(
        'External resource API "%s" returned an invalid shape. Response: %s',
        API_URL,
        json_encode($response)
    );
}

function errorMessageInvalidResponseStatus(object $response): string
{
    return sprintf(
        'External resource API "%s" returned an invalid status. Response: %s',
        API_URL,
        json_encode($response)
    );
}

function errorMessageInvalidArticleShape(object $response): string
{
    return sprintf(
        'External resource API "%s" returned an invalid article shape. Response: %s',
        API_URL,
        json_encode($response)
    );
}

function errorMessageInvalidArticlesShape(object $response): string
{
    return sprintf(
        'External resource API "%s" returned an invalid articles shape. Response: %s',
        API_URL,
        json_encode($response)
    );
}

$response = factoryResponse();

beforeEach(function () use ($response) {
    Log::spy();

    $this->mock(HttpService::class, function ($mock) use ($response) {
        $mock->shouldReceive('getAsObject')->andReturn($response);
    });

    ExternalResourcesApi::factory()->create([
        'api_url' => API_URL
    ]);
});

afterEach(function () use ($response) {
    $response->status = 'ok';
    $response->count = 1;
    $response->articles = [factoryArticle()];

    ExternalResourcesApi::truncate();
});

it('should call logInvalidShapeError and log the error if the status is missing from the response', function () use ($response) {
    unset($response->status);

    importExternalResource();

    $this->assertTrue(true);

    $message = errorMessageInvalidResponseShape($response);
    Log::shouldHaveReceived('error')->once()->with($message);
});

it('should call logInvalidStatusError and log the error if the status is not equal with ok', function () use ($response) {
    $response->status = 'fail';

    importExternalResource();

    $this->assertTrue(true);

    $message = errorMessageInvalidResponseStatus($response);
    Log::shouldHaveReceived('error')->once()->with($message);
});

it('should call logInvalidShapeError and log the error if the articles is missing from the response', function () use ($response) {
    unset($response->articles);

    importExternalResource();

    $this->assertTrue(true);

    $message = errorMessageInvalidResponseShape($response);
    Log::shouldHaveReceived('error')->once()->with($message);
});

it('should call logInvalidArticlesError and log the error if the articles is not an array', function () use ($response) {
    $response->articles = '#';

    importExternalResource();

    $this->assertTrue(true);

    $message = errorMessageInvalidArticlesShape($response);
    Log::shouldHaveReceived('error')->once()->with($message);
});

it('should call logInvalidArticleShapeError and log the error if the article is missing the id', function () use ($response) {
    unset($response->articles[0]->id);

    importExternalResource();

    $this->assertTrue(true);

    $message = errorMessageInvalidArticleShape($response->articles[0]);
    Log::shouldHaveReceived('error')->once()->with($message);
});

it('should call logInvalidArticleShapeError and log the error if the article is missing the title', function () use ($response) {
    unset($response->articles[0]->title);

    importExternalResource();

    $this->assertTrue(true);

    $message = errorMessageInvalidArticleShape($response->articles[0]);
    Log::shouldHaveReceived('error')->once()->with($message);
});

it('should call logInvalidArticleShapeError and log the error if the article is missing the description', function () use ($response) {
    unset($response->articles[0]->description);

    importExternalResource();

    $this->assertTrue(true);

    $message = errorMessageInvalidArticleShape($response->articles[0]);
    Log::shouldHaveReceived('error')->once()->with($message);
});

it('should call logInvalidArticleShapeError and log the error if the article is missing the publishedAt', function () use ($response) {
    unset($response->articles[0]->publishedAt);

    importExternalResource();

    $this->assertTrue(true);

    $message = errorMessageInvalidArticleShape($response->articles[0]);
    Log::shouldHaveReceived('error')->once()->with($message);
});

// TODO: Tests Create or update posts....
