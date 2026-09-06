<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Beehiiv\Facades\Beehiiv;

it('lists publications', function () {
    Http::fake([
        '*/publications*' => Http::response(['data' => [['id' => 'pub_1']]]),
    ]);

    $result = Beehiiv::publications()->list();

    expect($result['data'][0]['id'])->toBe('pub_1');

    Http::assertSent(fn ($request) => str_contains((string) $request->url(), '/v2/publications')
        && $request->hasHeader('Authorization', 'Bearer test-api-key'));
});

it('gets a single publication', function () {
    Http::fake(['*/publications/pub_1' => Http::response(['data' => ['id' => 'pub_1']])]);

    $result = Beehiiv::publications()->get('pub_1');

    expect($result['data']['id'])->toBe('pub_1');
});
