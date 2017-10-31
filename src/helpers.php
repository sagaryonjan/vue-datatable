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

if (! function_exists('renderDatable')) {

    /**
     * @param $data
     * @return \Illuminate\Foundation\Application|mixed
     */
    function renderDatable($data)
    {
        $datable = app('datable');

        if (! is_null($datable)) {
            return $datable->render($data);
        }

        return $datable;
    }

}