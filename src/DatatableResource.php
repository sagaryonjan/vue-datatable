<?php
/**
 * Created by PhpStorm.
 * User: Sagar
 * Date: 9/24/2017
 * Time: 9:47 AM
 */

namespace SagarYonjan\VueDatatable;

use Illuminate\Http\Request;
use SagarYonjan\VueDatatable\Contract\DatatableResourceInterface;

class DatatableResource extends DatatableResourceInterface
{

    /**
     * @var dataTable
     */
    protected $dataTable;

    /**
     * DatatableResource constructor.
     * @param DataBuilder $dataTable
     */
    public function __construct(DataBuilder $dataTable)
    {
        $this->dataTable = $dataTable;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {

       // dd($this->dataTable->customColumn());
        return response()->json([
            'data' => [
                'table'         => $this->dataTable->getTable(),
                'displayable'   => array_values($this->dataTable->displayColumn()),
                'updateable'    => array_values($this->dataTable->updateColumn()),
                'records'       => $this->getRecords()['collection'],
                'paginate'       => $this->getRecords()['paginate'],
                'quick_search'  => $this->dataTable->quickSearch(),
                'custom_column' => $this->dataTable->customColumn()
            ]
        ]);
    }

/*
    public function delete($id, Request $request) {

    }*/

}