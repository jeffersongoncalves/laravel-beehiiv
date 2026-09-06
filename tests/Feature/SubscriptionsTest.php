<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Beehiiv\Exceptions\BeehiivException;
use JeffersonGoncalves\Beehiiv\Facades\Beehiiv;

it('lists subscriptions using the default publication id', function () {
    Http::fake([
        '*/subscriptions*' => Http::response(['data' => [['id' => 'sub_1', 'email' => 'jane@example.com']]]),
    ]);

    $result = Beehiiv::subscriptions()->list(filters: ['email' => 'jane@example.com']);

    expect($result['data'][0]['email'])->toBe('jane@example.com');

    Http::assertSent(fn ($request) => str_contains((string) $request->url(), '/publications/pub_00000000-0000-0000-0000-000000000000/subscriptions?')
        && str_contains((string) $request->url(), 'email=jane%40example.com'));
});

it('gets a single subscription', function () {
    Http::fake(['*/subscriptions/sub_1' => Http::response(['data' => ['id' => 'sub_1']])]);

    $result = Beehiiv::subscriptions()->get('sub_1');

    expect($result['data']['id'])->toBe('sub_1');
});

it('creates a subscription', function () {
    Http::fake(['*/subscriptions' => Http::response(['data' => ['id' => 'sub_1']], 201)]);

    $result = Beehiiv::subscriptions()->create(['email' => 'jane@example.com']);

    expect($result['data']['id'])->toBe('sub_1');
    Http::assertSent(fn ($request) => $request['email'] === 'jane@example.com');
});

it('requires an email to create a subscription', function () {
    Beehiiv::subscriptions()->create([]);
})->throws(InvalidArgumentException::class, 'The "email" attribute is required.');

it('updates a subscription', function () {
    Http::fake(['*/subscriptions/sub_1' => Http::response(['data' => ['id' => 'sub_1', 'tier' => 'premium']])]);

    $result = Beehiiv::subscriptions()->update('sub_1', ['tier' => 'premium']);

    expect($result['data']['tier'])->toBe('premium');
});

it('deletes a subscription', function () {
    Http::fake(['*/subscriptions/sub_1' => Http::response([])]);

    Beehiiv::subscriptions()->delete('sub_1');

    Http::assertSent(fn ($request) => $request->method() === 'DELETE');
});

it('requires a publication id when none is configured', function () {
    config()->set('beehiiv.publication_id', null);

    Beehiiv::subscriptions()->list();
})->throws(InvalidArgumentException::class);

it('throws a BeehiivException on a failed request', function () {
    Http::fake(['*/subscriptions/sub_1' => Http::response(['message' => 'Subscription not found'], 404)]);

    Beehiiv::subscriptions()->get('sub_1');
})->throws(BeehiivException::class, 'Subscription not found');
