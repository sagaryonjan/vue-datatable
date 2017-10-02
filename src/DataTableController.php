<?php

namespace SagarYonjan\VueDatatable;

use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;
use Exception;
use SagarYonjan\VueDatatable\DatatableTrait\SetDataTable;

abstract class DataTableController extends Controller
{


    use SetDataTable;

    /**
     * @var $builder
     */
    protected $builder;

    /**
     * TableController constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->builder();

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
     * @param  string  $method
     * @param  array  $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        return call_user_func_array([$this->initDataTableResource(), $method ], $args);
    }

}
