<?php

namespace JeffersonGoncalves\Beehiiv;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class BeehiivServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('beehiiv')
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(Beehiiv::class, function () {
            $publicationId = config('beehiiv.publication_id');

            return new Beehiiv(
                (string) config('beehiiv.api_key'),
                $publicationId !== null && $publicationId !== '' ? (string) $publicationId : null,
                (int) config('beehiiv.default_limit', 10),
            );
        });
    }
}
