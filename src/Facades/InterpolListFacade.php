<?php

namespace Jota\InterpolList\Facades;

use Illuminate\Support\Facades\Facade;

class InterpolListFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'InterpolList';
    }
}
