<?php

namespace SagarYonjan\VueDatatable;

use Exception;
use BadMethodCallException;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use SagarYonjan\VueDatatable\Services\DataBuilder;

abstract class DataTableController extends Controller
{
    /**
     * @var $builder
     */
    public $builder;

    /**
     * @var $query
     */
    public $query;

    /**
     * @var $add_column
     */
    public $add_column;

    /**
     * Methods Available
     *
     * @var array $methods;
     */
    private $methods = [ 'builder', 'query', 'addColumn' ];

    /**
     * TableController constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->initSetup();

        if (!$this->builder instanceof Builder) {

            throw new Exception('This model is not instance of Builder');

        }

    }

    /**
     *  builder
     */
    public function builder()
    {
        $builder = $this->model;

        $this->builder = $builder::query();
    }

    /**
     * initial Setup
     */
    public function initSetup()
    {
        if($this->methods) {

            foreach ($this->methods as $method) {

                if(method_exists($this, $method))
                    $this->$method();

            }

        }

    }

    /**
     * @param $datatable
     * @return mixed
     */
    public function set($datatable)
    {
        foreach ($this->property() as $property => $value) {
            $datatable->{$property} = $value;
        }

        return $datatable;
    }

    /**
     * @return mixed
     */
    public function setProperty()
    {
        return $this->set( new DataBuilder($this) );
    }

    /**
     * @return DatatableResource
     */
    public function initDataTable()
    {
        return new DatatableResource( $this->setProperty() );
    }

    /**
     * @return array
     */
    public function property()
    {
        return get_object_vars($this);
    }

    /**
     * @param $method
     * @param $args
     * @return mixed
     */
    public function getDynamicMethods($method, $args) {

       return call_user_func_array([$this->initDataTable(), $method ], $args);
    }

    /**
     * Dynamically handle calls to the class.
     *
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        if (method_exists($this->initDataTable(), $method)) {
            return $this->getDynamicMethods($method, $args);
        }

        throw new BadMethodCallException("Method {$method} does not exist.");

    }

}
