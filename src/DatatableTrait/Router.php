<?php

namespace SagarYonjan\VueDatatable\DatatableTrait;

use Route;

trait Router
{

    /**
     * @param $routes
     */
    public function manageRoute($routes)
    {
        foreach ($this->default_route as $method => $default_route) {

            $method           = strtolower($method);
            $routes['url']    = $this->checkRouteForParam($default_route, $routes);

            if(count($this->options) > 0) {

                if( in_array($default_route['action'], $this->options) ) {

                    $this->getRoute($method, $routes, $default_route);

                }

            } else {

                $this->getRoute($method, $routes, $default_route);

            }



        }
    }

    /**
     * @param $method
     * @param $routes
     * @param $default_route
     * @return mixed
     */
    public function getRoute($method, $routes, $default_route)
    {
        return  Route::$method(
            $routes['url'],
            $routes['controller'].'@'.$default_route['action']
        )->name(
            $this->prefix.'.'.$routes['panel'].'.'.$default_route['action']
        );
    }



    /**
     * @param $default_route
     * @param $routes
     * @return string
     */
    public function checkRouteForParam($default_route, $routes)
    {
        if($default_route['param'] == true) {

            $url =     $this->prefix.'/'.$routes['panel'].'/{id}';

        } else {

            $url =  $this->prefix.'/'.$routes['panel'];

        }

        return $url;
    }

    /**
     * @param array ...$options
     * @return $this
     */
    public function only(...$options)
    {
        $this->options = $options;

        return $this;
    }

}