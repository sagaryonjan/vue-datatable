<?php


namespace SagarYonjan\VueDatatable\Contract;

use Illuminate\Support\Facades\Schema;

abstract class DataTableOption
{

    /**
     * @return mixed
     */
//    abstract function run();

    /**
     * Initiate Dataable
     */
    public function initDatable()
    {

        foreach ($this->methods() as $method) {

            $action = $method->name;

            $this->$action();
        }

        return $this;

    }






    /**
     * @return mixed
     */
    protected function getDatabaseColumnNames()
    {
        return Schema::getColumnListing($this->builder->getModel()->getTable());
    }



    public function methods()
    {
        $class = new \ReflectionClass($this);

        $methods = $class->getMethods(\ReflectionMethod::IS_PROTECTED);

        return $methods;
    }

    public function ifNull($data)
    {
        return $data === NULL;
    }


}