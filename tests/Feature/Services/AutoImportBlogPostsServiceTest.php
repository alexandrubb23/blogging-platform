<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use Illuminate\Support\Facades\Log;

use App\Services\HttpService;
use App\Models\ExternalResourcesApi;
use Tests\Helpers\Services\AutoImportBlogPostsHelper;

$article = AutoImportBlogPostsHelper::factoryArticle(1, "a", "b", "2021-01-01 00:00:00");
$response = AutoImportBlogPostsHelper::factoryResponse("ok", 1, [$article]);

beforeEach(function () use ($response) {
    Log::spy();

    $this->mock(HttpService::class, function ($mock) use ($response) {
        $mock->shouldReceive('getAsObject')->andReturn($response);
    });

    ExternalResourcesApi::factory()->create([
        'user_id' => 1,
        'api_url' => AutoImportBlogPostsHelper::API_URL
    ]);
});

afterEach(function () use ($response) {
    $response->status = 'ok';
    $response->count = 1;
    $response->articles = [AutoImportBlogPostsHelper::factoryArticle(1, "a", "b", "2021-01-01 00:00:00")];

    BlogPost::truncate();
    ExternalResourcesApi::truncate();
});

it('should log a validation error if the status is missign from the response', function () use ($response) {
    unset($response->status);

    AutoImportBlogPostsHelper::importExternalResource();

    $this->assertTrue(true);

    AutoImportBlogPostsHelper::logErrorHaveBeenCalledOnceWithMessage('The status field is required.');
});

it('should log a validation error if the status is not equal with ok', function () use ($response) {
    $response->status = 'no';

    AutoImportBlogPostsHelper::importExternalResource();

    $this->assertTrue(true);

    AutoImportBlogPostsHelper::logErrorHaveBeenCalledOnceWithMessage('The selected status is invalid.');
});

it('should log a validation error if the articles is missign from the response', function () use ($response) {
    unset($response->articles);

    AutoImportBlogPostsHelper::importExternalResource();

    $this->assertTrue(true);

    AutoImportBlogPostsHelper::logErrorHaveBeenCalledOnceWithMessage('The articles field is required.');
});

it('should log a validation error if the articles it is in the response but has an invalid structure', function () use ($response) {
    $response->articles  = '+';

    AutoImportBlogPostsHelper::importExternalResource();

    $this->assertTrue(true);

    AutoImportBlogPostsHelper::logErrorHaveBeenCalledOnceWithMessage('The articles must be an array.');
});


foreach (['id', 'title', 'description', 'published at'] as $field) {
    it(sprintf('should log a validation error if the %s is missing from an article', $field), function () use ($response, $field) {
        $property = AutoImportBlogPostsHelper::normalizePropertyName($field);

        unset($response->articles[0]->$property);

        AutoImportBlogPostsHelper::importExternalResource();

        $this->assertTrue(true);

        AutoImportBlogPostsHelper::logErrorHaveBeenCalledOnceWithMessage(sprintf('The %s field is required.', $field));
    });
}

it('should import an article if it has a valid shape', function () use ($response) {
    AutoImportBlogPostsHelper::importExternalResource();

    $post = BlogPost::first();

    $this->assertEquals($post->title, 'a');
});

it('should not import an article if already exists', function () use ($response) {
    BlogPost::create([
        'title' => 'a',
        'description' => 'b',
        'published_at' => '2021-01-01 00:00:00',
        'user_id' => 1,
    ]);

    AutoImportBlogPostsHelper::importExternalResource();

    $countPosts = BlogPost::count();

    $this->assertEquals($countPosts, 1);
});

it('should update an article if the resource has change the title or the description', function () use ($response) {
    AutoImportBlogPostsHelper::importExternalResource();

    $response->articles[0]->title = 'c';
    $response->articles[0]->description = 'd';

    AutoImportBlogPostsHelper::importExternalResource();

    $post = BlogPost::first();

    $this->assertEquals($post->title, 'c');
    $this->assertEquals($post->description, 'd');
});
