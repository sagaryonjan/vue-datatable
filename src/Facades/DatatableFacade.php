<?php

namespace SagarYonjan\VueDatatable\Facades;


use Illuminate\Support\Facades\Facade;

class DatatableFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'datable';
    }
}
