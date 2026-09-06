<?php

use JeffersonGoncalves\Beehiiv\Beehiiv as BeehiivManager;
use JeffersonGoncalves\Beehiiv\Facades\Beehiiv;

it('merges the default config', function () {
    expect(config('beehiiv.default_limit'))->toBe(10);
});

it('resolves the facade to the manager singleton', function () {
    expect(Beehiiv::getFacadeRoot())->toBeInstanceOf(BeehiivManager::class);
});

it('always resolves the same manager instance', function () {
    expect(app(BeehiivManager::class))->toBe(app(BeehiivManager::class));
});
