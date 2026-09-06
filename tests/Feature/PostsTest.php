<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Beehiiv\Facades\Beehiiv;

it('lists posts', function () {
    Http::fake([
        '*/posts*' => Http::response(['data' => [['id' => 'post_1', 'title' => 'Hello World']]]),
    ]);

    $result = Beehiiv::posts()->list(filters: ['status' => 'confirmed']);

    expect($result['data'][0]['title'])->toBe('Hello World');

    Http::assertSent(fn ($request) => str_contains((string) $request->url(), 'status=confirmed'));
});

it('gets a single post', function () {
    Http::fake(['*/posts/post_1' => Http::response(['data' => ['id' => 'post_1']])]);

    $result = Beehiiv::posts()->get('post_1');

    expect($result['data']['id'])->toBe('post_1');
});

it('creates a post', function () {
    Http::fake(['*/posts' => Http::response(['data' => ['id' => 'post_1']], 201)]);

    $result = Beehiiv::posts()->create(['title' => 'Hello World']);

    expect($result['data']['id'])->toBe('post_1');
    Http::assertSent(fn ($request) => $request['title'] === 'Hello World');
});

it('requires a title to create a post', function () {
    Beehiiv::posts()->create([]);
})->throws(InvalidArgumentException::class, 'The "title" attribute is required.');

it('deletes a post', function () {
    Http::fake(['*/posts/post_1' => Http::response([])]);

    Beehiiv::posts()->delete('post_1');

    Http::assertSent(fn ($request) => $request->method() === 'DELETE');
});
