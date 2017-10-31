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


    public function route($panel, $controller) {

        Route::get(
            $this->prefix.'/'.$panel,
            $controller.'@index'
        )->name(
            $this->prefix.'.'.$panel.'.index'
        );
        return $this;
    }


    /**
     * @param $panel
     * @param $controller
     * @return $this
     */
    public function routesPanel($panel, $controller) {

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

    /**
     * @param $route
     * @return string
     */
    public function htmlTable($route) {
       return $this->merge($this->openTag( route($this->prefix.'.'.$route.'.index') ), $this->closeTag());
    }

    /**
     * @param $url
     * @return string
     */
    public function openTag($url)
    {
        return '<'.$this->vue_table_tag
                  . '  '
                  .$this->vue_route_tag
                  . '="'.$url. '">';
    }

    /**
     * @param array ...$html
     * @return string
     */
    public function merge(...$html)
    {
        return implode(' ', $html);
    }

    /**
     * @return string
     */
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

    /**
     * @param $controller
     * @param $model
     */
    public  function createController($controller , $model)
    {
        if (!file_exists(base_path('app/Http/Controllers/DataTable'))) {
            mkdir(base_path('app/Http/Controllers/DataTable'));
        }

        $templateDirectory = __DIR__ . '/stubs';

        $md = file_get_contents($templateDirectory . "/controller.stub");

        $md = str_replace("__controller_class_name__", $controller, $md);
        $md = str_replace("__model_name__", $model, $md);

        file_put_contents( base_path('app/Http/Controllers/DataTable/' . $controller . ".php"), $md );
    }

}