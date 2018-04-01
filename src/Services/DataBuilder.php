<?php

namespace SagarYonjan\VueDatatable\Services;

use Illuminate\Support\Facades\Schema;
use SagarYonjan\VueDatatable\Helpers\TableRecord;
use SagarYonjan\VueDatatable\DatatableTrait\Pagination;

class DataBuilder implements DataBuilderInterface
{

    use Pagination;

    /**
     * @var $displayColumn
     */
    public $displayColumn;

    /**
     * Page Drop Down
     * @var int
     */
    public $page_dropdown = 4;

    /**
     * @var $builder
     */
    public $builder;

    /**
     * @var bool
     */
    public $quick_search = false;

    /**
     * @var $quickSearchFilter
     */
    public $quick_search_filter = [];

    /**
     * @var $query
     */
    public $query;

    /***
     * @var array $addColumn
     */
    public $add_column;

    /**
     * @var int $pagination
     */
    public $pagination = 20;

    /**
     * @var $controller
     */
    private $controller;

    /**
     * @var $getColumn
     */
    private $getColumn;

    /**
     * @var
     */
    private $set_pagination;

    /**
     * DataBuilder constructor.
     * @param $controller
     */
    public function __construct($controller)
    {
        $this->controller = $controller;
    }

    /**
     * @return array
     */
    public function displayColumn()
    {
        if (!$this->displayColumn) {

            return $this->getColumn();
        }

        return array_keys($this->displayColumn);

    }

    /**
     * @return array
     */
    public function displayColumnName()
    {
        if (!$this->displayColumn) {
            return $this->getColumn();
        }

        return array_values($this->displayColumn);
    }

    /**
     * Show quick search
     *
     * @return bool
     */
    public function quickSearch(): bool
    {
        return $this->quick_search;
    }

    /**
     * @return array
     */
    public function quickSearchFilter()
    {

        if (!$this->quick_search_filter) {
            $this->quick_search_filter = $this->getColumn();
        }

        return $this->quick_search_filter;
    }

    /**
     * @return int $pagination
     */
    public function pagination()
    {
        return $this->pagination;
    }

    /**
     * @param null $custom
     */
    public function setPagination($custom = null)
    {
        if($custom) {
            $this->set_pagination = $custom;
        }
        else {

            $this->set_pagination = $this->pagination;
        }

    }


    /**
     * Controller
     */
    public function controller() {

        return $this->controller;

    }

    /**
     * Query for datatable
     */
    public function query() {

        return $this->query;

    }

    public function builder() {

        if($this->query())
            return $this->query();
        else
            return $this->builder;

    }

    /**
     * @return array
     */
    public function addColumn() {

        return $this->add_column;

    }

    /**
     * Get all records form db
     *
     * @return mixed
     */
    public function getTableRecords()
    {
       return (new TableRecord($this))->get();
    }

    /**
     * Get Hidden Field
     *
     * @return mixed
     */
    public function getHiddenField() {

        return $this->builder->getModel()->getHidden();

    }

    /**
     * Get Table Name
     *
     * @return mixed
     */
    public function getTable() {

        return $this->builder->getModel()->getTable();

    }

    /**
     * Get Columns
     *
     * @return array
     */
    public function getColumn()
    {
        $this->getColumn =  array_diff($this->getDatabaseColumnNames(), $this->getHiddenField() );
        return $this->getColumn;
    }

    /**
     * Get Database Column name
     *
     * @return mixed
     */
    protected function getDatabaseColumnNames()
    {
        return Schema::getColumnListing($this->getTable());
    }

}