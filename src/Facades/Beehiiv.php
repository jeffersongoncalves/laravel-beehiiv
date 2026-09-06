<?php

namespace JeffersonGoncalves\Beehiiv\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \JeffersonGoncalves\Beehiiv\Beehiiv
 */
class Beehiiv extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \JeffersonGoncalves\Beehiiv\Beehiiv::class;
    }
}
