<?php

if (! function_exists('datableRoute')) {

    /**
     * Create Route
     *
     * @param $panel
     * @param $controller
     * @return mixed
     */
    function datableRoute($panel, $controller)
    {
        $datable = app('datable');

        if (! is_null($datable)) {
            return $datable->route($panel, $controller);
        }

        return $datable;
    }

}