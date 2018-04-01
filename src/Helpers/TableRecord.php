<?php

namespace SagarYonjan\VueDatatable\Helpers;

use SagarYonjan\VueDatatable\DatatableTrait\HtmlMixter;
use SagarYonjan\VueDatatable\Filters\QuickFilter;
use SagarYonjan\VueDatatable\Services\DataBuilderInterface;

class TableRecord
{
    use HtmlMixter;

    /**
     * @var $data_builder
     */
    private $data_builder;

    /**
     * @var $collection
     */
    private $collection;

    /**
     * @var $records
     */
    public $records;

    /**
     * @var $paginate
     */
    public $paginate;

    /**
     * TableRecord constructor.
     * @param DataBuilderInterface $data_builder
     */
    public function __construct(DataBuilderInterface $data_builder)
    {
        $this->data_builder = $data_builder;
    }

    /**
     * Table data and pagination
     */
    public function get() {

        $this->collection = $this->dataWithPaginateOrGet();

        $this->getAllRecords();

        $this->getPaginationData();

        return $this;
    }

    public function dataWithPaginateOrGet() {

        $pagination = $this->data_builder->pagination();

        if(request()->limit) {
            $this->data_builder->setPagination(request()->limit);
            $pagination = request()->limit;
        }
        return  $this->quickFilter()->paginate($pagination);

    }

    /**
     * Quick Filter
     * @return mixed
     */
    public function quickFilter() {

        $filters = $this->data_builder->quickSearchFilter();

        if(count($filters) > 0) {

            $quick_filter =  new QuickFilter($this->data_builder->builder(), $filters);

            return $quick_filter->query();

        } else {

            return $this->data_builder->query();
        }
    }

    /**
     * Get Pagination Data
     *
     * @return array
     */
    public function getPaginationData() {

        $this->paginate  =  [
            'count'           => $this->collection->count(),
            'currentPage'     => $this->collection->currentPage(),
            'firstItem'       => $this->collection->firstItem(),
            'hasMorePages'    => $this->collection->hasMorePages(),
            'lastItem'        => $this->collection->lastItem(),
            'lastPage'        => $this->collection->lastPage(),
            'nextPageUrl'     => $this->collection->nextPageUrl(),
            'perPage'         => $this->collection->perPage(),
            'previousPageUrl' => $this->collection->previousPageUrl(),
            'total'           => $this->collection->total(),
        ];
    }

    /**
     * Get All Record
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllRecords() {

        $data = [];

        foreach ( $this->collection as $key => $collect ) {

            foreach ($this->data_builder->displayColumn() as $value) {

                if($value == 'action') {

                    $data[$key][$value] = $this->render('action', $collect);

                }
                elseif($value == 'created_at' || $value == 'updated_at' ) {

                    $data[$key][$value] = $collect->{$value}->format('d-m-Y');

                }
                else {
                    if( method_exists($this->data_builder->controller(), $value) ) {

                        $data[$key][$value] =  $this->data_builder->controller()->{$value}($collect);

                    } else {

                        $data[$key][$value] = $collect->{$value};

                    }
                }

            }

        }

        $this->records = collect($data);
    }

    /**
     * @param $action
     * @param $collect
     * @return string
     */
    public function render($action, $collect)
    {
        $data_array = $this->data_builder->addColumn()[$action];

        $html = ' ';

        if(count($data_array) > 0) {

            foreach ($data_array as $data_ary)  {

                $html .= $this->output($this->tags($data_ary, $collect));

            }

        }

        return $html;

    }

}