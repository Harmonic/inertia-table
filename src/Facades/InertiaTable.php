<?php

namespace harmonic\InertiaTable\Facades;

use Illuminate\Support\Facades\Facade;

class InertiaTable extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'inertiatable';
    }
}
