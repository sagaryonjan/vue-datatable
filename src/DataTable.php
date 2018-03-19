<?php

namespace SagarYonjan\VueDatatable;

use Route;
use Illuminate\Support\HtmlString;

class DataTable
{
    /**
     * @var string
     */
    protected $prefix = 'datatable';

    /**
     * @var string
     */
    private $vue_table_tag = 'data-table';

    /**
     * @var string
     */
    private $vue_route_tag = 'url';

    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    private $namespace = 'App\Http\Controllers\DataTable\\';

    /**
     * @param $panel
     * @param $controller
     * @return $this
     */
    public function route($panel, $controller) {

        Route::get(
            $this->prefix.'/'.$panel,
            $this->namespace.$controller.'@index'
        )->name(
            $this->prefix.'.'.$panel.'.index'
        );
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

}