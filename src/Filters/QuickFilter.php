<?php
namespace SagarYonjan\VueDatatable\Filters;

class QuickFilter
{
    /**
     * @var $builder
     */
    private $builder;

    /**
     * @var $filters
     */
    private $filters;

    /**
     * QuickFilter constructor.
     * @param $builder
     * @param $filters
     */
    public function __construct($builder, $filters)
    {
        $this->builder = $builder;
        $this->filters = $filters;
    }

    /**
     * Run Query
     */
    public function query()
    {
       $query = $this->builder->where(function ($query) {

            if(request()->has('quick_search')) {

                foreach ($this->filters as $key => $filter) {

                    if($key == 0) {

                        $query->where($filter, 'like', '%' .request('quick_search'). '%');

                    } else {

                        $query->orWhere($filter, 'like', '%' .request('quick_search'). '%');

                    }

                }

            }
        });

       return $query;
    }

}