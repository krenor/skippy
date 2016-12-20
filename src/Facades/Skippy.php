<?php

namespace Skippy\Facades;

use Illuminate\Support\Facades\Facade;

class Skippy extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'skippy';
    }
}
