<?php

namespace SagarYonjan\VueDatatable\Contract;

use Illuminate\Http\Request;
use HTML;
use SagarYonjan\VueDatatable\DatatableTrait\HtmlMixter;

abstract class DatatableResourceInterface
{

    use HtmlMixter;

    /**
     * @return mixed
     */
    abstract function index();

    /**
     * @return mixed
     */
   // abstract function delete();

    /**
     * @return mixed
     */
    protected function getRecords()
    {
        $filters = $this->dataTable->quickSearchFilter();
        $data= [];
        $collection = $this->dataTable->builder
            /*->take(request()->limit)*/
            ->orderBy('id')
            ->select($this->select())
            ->where(function ($query) use ($filters) {
                if(request()->has('quick_search')) {

                    foreach ($filters as $key => $filter) {
                        if($key == 0) {
                            $query->where($filter, 'like', '%' .request('quick_search'). '%');
                        } else {
                            $query->orWhere($filter, 'like', '%' .request('quick_search'). '%');
                        }


                    }

                }

            })
            ->paginate(request()->limit);


        $customs = array_diff($this->dataTable->displayColumn(), $this->dataTable->getColumn());

        foreach ( $collection as $collect ) {

            foreach ($customs as $custom) {

                $collect->{$custom}  =   $this->render($custom, $collect);//$this->dataTable->addColumn[$custom];

            }

        }


        $paginate = [
            'count' => $collection->count(),
            'currentPage' => $collection->currentPage(),
            'firstItem' => $collection->firstItem(),
            'hasMorePages' => $collection->hasMorePages(),
            'lastItem' => $collection->lastItem(),
            'lastPage' => $collection->lastPage(),
            'nextPageUrl' => $collection->nextPageUrl(),
            'perPage' => $collection->perPage(),
            'previousPageUrl' => $collection->previousPageUrl(),
            'total' => $collection->total(),
        ];

        $data['collection'] = $collection->diffAssoc($paginate);
        $data['paginate']   = $paginate;

        return $data;
    }

    public function select()
    {
        $customs = array_diff($this->dataTable->displayColumn(), $this->dataTable->getColumn());
        $select = $this->dataTable->displayColumn();

        foreach ($customs as $value) {

            if(($key = array_search($value, $select)) !== false) {
                unset($select[$key]);
            }

        }

        return $select;
    }

}