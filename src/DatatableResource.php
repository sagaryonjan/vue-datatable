<?php

namespace SagarYonjan\VueDatatable;

use SagarYonjan\VueDatatable\Services\DataBuilderInterface;

class DatatableResource extends DatatableResourceInterface
{
    /**
     * @var $data_builder
     */
    protected $data_builder;

    /**
     * DatatableResource constructor.
     * @param DataBuilderInterface $dataBuilder
     */
    public function __construct(DataBuilderInterface $dataBuilder)
    {
        $this->data_builder = $dataBuilder;

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $table_records = $this->data_builder->getTableRecords();
        return response()->json([
            'data' => [
                'displayable'      => $this->data_builder->displayColumn(),
                'displayable_name' => $this->data_builder->displayColumnName(),
                'records'          => $table_records->records,
                'paginate'         => $table_records->paginate,
                'pagination_limit' => $this->data_builder->setPagination(),
                'quick_search'     => $this->data_builder->quickSearch(),
                'page_dropdown'    => $this->data_builder->getPaginationDropDown(),
                'paginate_detail'  => [
                    'start_from'   => $this->data_builder->getPaginationStartFrom($table_records->paginate),
                    'end_to'       => $this->data_builder->getPaginationEndTo($table_records->paginate),
                    'total_count'  => $this->data_builder->getTotalCount($table_records->paginate),
                ],
            ]
        ]);
    }

}