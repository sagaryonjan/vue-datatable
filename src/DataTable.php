<?php

namespace SagarYonjan\VueDatatable;

use Route;
use Illuminate\Support\HtmlString;
use SagarYonjan\VueDatatable\DatatableTrait\Router;

class DataTable
{

    use Router;

    /**
     * @var string
     */
    protected $prefix = 'datatable';

    /**
     * action
     */
    Const ACTION = [ 'index', 'edit', 'delete' ];

    /**
     * @var array
     */
    protected $options = [];

    /**
     * All of the verbs supported by the router.
     *
     * @var array
     */
    public static $verbs = ['GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'];

    /**
     * @var array
     */
    public $default_route = [
            'GET'    =>  [ 'action' => 'index', 'param' => false ],
            'PATCH'  =>  [ 'action' => 'update', 'param' => true ],
            'DELETE' =>  [ 'action' => 'delete', 'param' => true ],
    ];

    /**
     * @var string
     */
    private $vue_table_tag = 'data-table';

    /**
     * @var string
     */
    private $vue_route_tag = 'endpoint';


    /**
     * @param $panel
     * @param $controller
     * @return $this
     */
    public function routes($panel, $controller) {

        $routes = [];
        $routes['panel'] = $panel;
        $routes['controller'] = $controller;
        $this->manageRoute($routes);
        return $this;
    }

    /**
     * @param $route
     * @return string
     */
    public function render($route)
    {
        return $this->toHtmlString($this->htmlTable($route));
    }

    public function htmlTable($route) {
       return $this->merge($this->openTag( route($this->prefix.'.'.$route.'.index') ), $this->closeTag());
    }


    public function openTag($url)
    {
        return '<'.$this->vue_table_tag
                  . '  '
                  .$this->vue_route_tag
                  . '="'.$url. '">';
    }


    public function merge(...$html)
    {
        return implode(' ', $html);
    }

    public function closeTag()
    {
     return "</".$this->vue_table_tag.">";
    }

    /**
     * Transform the string to an Html serializable object
     *
     * @param $html
     *
     * @return \Illuminate\Support\HtmlString
     */
    protected function toHtmlString($html)
    {
        return new HtmlString($html);
    }





}