<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Beehiiv\Facades\Beehiiv;

it('lists segments', function () {
    Http::fake(['*/segments' => Http::response(['data' => [['id' => 'seg_1']]])]);

    $result = Beehiiv::segments()->list();

    expect($result['data'][0]['id'])->toBe('seg_1');
});

it('gets a single segment', function () {
    Http::fake(['*/segments/seg_1' => Http::response(['data' => ['id' => 'seg_1']])]);

    $result = Beehiiv::segments()->get('seg_1');

    expect($result['data']['id'])->toBe('seg_1');
});

it('requires a publication id when none is configured', function () {
    config()->set('beehiiv.publication_id', null);

    Beehiiv::segments()->list();
})->throws(InvalidArgumentException::class);
