<?php

namespace SagarYonjan\VueDatatable\DatatableTrait;


use SagarYonjan\VueDatatable\DataBuilder;
use SagarYonjan\VueDatatable\DatatableResource;

trait SetDataTable
{

    /**
     * @return mixed
     */
    public function setProperty()
    {
        return $this->set( new DataBuilder() );
    }

    /**
     * @return DatatableResource
     */
    public function initDataTableResource()
    {
        return new DatatableResource( $this->setProperty() );
    }

    /**
     * @param $datatable
     * @return mixed
     */
    public function set($datatable)
    {

        foreach ($this->property() as $property => $value) {

            $datatable->$property = $value;

        }

        return $datatable;

    }

    /**
     * @return array
     */
    public function property()
    {
        return get_object_vars($this);
    }

}