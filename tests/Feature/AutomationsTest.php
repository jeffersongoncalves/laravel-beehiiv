<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Beehiiv\Facades\Beehiiv;

it('lists automations', function () {
    Http::fake(['*/automations' => Http::response(['data' => [['id' => 'aut_1']]])]);

    $result = Beehiiv::automations()->list();

    expect($result['data'][0]['id'])->toBe('aut_1');
});

it('gets a single automation', function () {
    Http::fake(['*/automations/aut_1' => Http::response(['data' => ['id' => 'aut_1']])]);

    $result = Beehiiv::automations()->get('aut_1');

    expect($result['data']['id'])->toBe('aut_1');
});

it('requires a publication id when none is configured', function () {
    config()->set('beehiiv.publication_id', null);

    Beehiiv::automations()->list();
})->throws(InvalidArgumentException::class);
