<?php
namespace SagarYonjan\VueDatatable\Services;

interface DataBuilderInterface
{

    /**
     * Display column in List
     *
     * @return mixed
     */
    public function displayColumn();

    /**
     * Show quick search
     *
     * @return bool
     */
    public function quickSearch() : bool;

    /**
     * @return mixed
     */
    public function quickSearchFilter();

    /**
     * Get All Records
     *
     * @return mixed
     */
    public function getTableRecords();

    /**
     * Pagination Number
     *
     * @return mixed
     */
    public function pagination();

    /**
     * Query builder
     *
     * @return mixed
     */
    public function query();

    /**
     * Current Controller
     *
     * @return mixed
     */
    public function controller();

    /**
     * @return mixed
     */
    public function addColumn();

    /**
     * Builder
     *
     * @return mixed
     */
    public function builder();

    /**
     * Get Pagination DropDown
     * @return mixed
     */
    public function getPaginationDropDown();

    /**
     * @param $data
     * @return mixed
     */
    public function getPaginationStartFrom($data);

    /**
     * @param $data
     * @return mixed
     */
    public function getTotalCount($data);

    /**
     * @param $data
     * @return mixed
     */
    public function getPaginationEndTo($data);

    public function setPagination($custom=null);

    public function displayColumnName();

}