<?php
namespace SagarYonjan\VueDatatable;

use SagarYonjan\VueDatatable\Contract\DataTableOption;

class DataBuilder extends DataTableOption
{

    /**
     * @var $displayColumn
     */
    public $displayColumn;

    /**
     * @var updateColumn
     */
    public $updateColumn;

    /**
     * public $updateValidate
     */
    public $updateValidate;

    /**
     * @var $builder
     */
    public $builder;

    /**
     * @var bool
     */
    public $quick_search = false;

    /**
     * @var $addColumn
     */
    public $addColumn;

    /**
     * @var $getColumn
     */
    public $getColumn;

    /**
     * @var
     */
    public $quickSearchFilter;

    /**
     * @var $customColumn
     */
    private $customColumn;

    /**
     * @return bool $quick_search
     */
    public function quickSearch() {

        return $this->quick_search;

    }

    public function quickSearchFilter() {

        if( $this->ifNull( $this->quickSearchFilter ) ) {

            $this->quickSearchFilter = $this->getColumn();

        }

        return $this->quickSearchFilter;

    }

    /**
     * @return array
     */
    public function displayColumn()
    {

        if( $this->ifNull( $this->displayColumn ) ) {

            $this->displayColumn = $this->getColumn();

        }
        return $this->displayColumn;

    }





    public function getColumn()
    {
        $this->getColumn =  array_diff($this->getDatabaseColumnNames(), $this->builder->getModel()->getHidden());
        return $this->getColumn;
    }

    /**
     * @return $this
     */
    public function updateColumn()
    {

        if( $this->ifNull($this->updateColumn) ) {

            $this->updateColumn = $this->displayColumn();

        }

        return $this->updateColumn;

    }

    /**
     * @return mixed
     */
    public function getTable()
    {
        return $this->builder->getModel()->getTable();
    }

    /**
     * @return array
     */
    public function customColumn()
    {
        $this->customColumn =  array_diff($this->displayColumn(), $this->getColumn());

        return $this->customColumn;
    }

    /**
     * @param $controller
     * @param $model
     */
    public static function createController($controller , $model)
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