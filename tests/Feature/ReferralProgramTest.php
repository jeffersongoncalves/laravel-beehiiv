<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Beehiiv\Facades\Beehiiv;

it('gets the referral program', function () {
    Http::fake(['*/referral_program' => Http::response(['data' => ['is_referral_enabled' => true]])]);

    $result = Beehiiv::referralProgram()->get();

    expect($result['data']['is_referral_enabled'])->toBeTrue();
});

it('requires a publication id when none is configured', function () {
    config()->set('beehiiv.publication_id', null);

    Beehiiv::referralProgram()->get();
})->throws(InvalidArgumentException::class);
