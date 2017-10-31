<?php
/**
 * Created by PhpStorm.
 * User: Sagar
 * Date: 9/24/2017
 * Time: 9:47 AM
 */

namespace SagarYonjan\VueDatatable;

use SagarYonjan\VueDatatable\DatatableResourceInterface;
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
                'displayable'   => array_values($this->data_builder->displayColumn()),
                'records'       => $table_records->records,
                'paginate'      => $table_records->paginate,
                'quick_search'    => $this->data_builder->quickSearch(),
                'paginate_detail' => [
                    'start_from'  => $this->data_builder->getPaginationStartFrom($table_records->paginate),
                    'end_to'      => $this->data_builder->getPaginationEndTo($table_records->paginate),
                    'total_count' => $this->data_builder->getTotalCount($table_records->paginate),
                ],
            ]
        ]);
    }

}