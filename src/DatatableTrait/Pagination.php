<?php
/**
 * Created by PhpStorm.
 * User: Sgr Ynjn
 * Date: 11/1/2017
 * Time: 12:44 AM
 */

namespace SagarYonjan\VueDatatable\DatatableTrait;


use Illuminate\Pagination\LengthAwarePaginator;

trait Pagination
{


    public function getPaginationStartFrom($data)
    {

        if ($data['total'] == 0)
            return 0;

        if ($data['currentPage'] == 1)
            return 1;

        $start = (($data['currentPage'] * $data['perPage']) - $data['perPage']) + 1;
        if ($start > $data['total'])
            return 0;

        return $start;
    }

    public function getPaginationEndTo($data)
    {
        $start = (($data['currentPage'] * $data['perPage']) - $data['perPage']) + 1;
        if ($start > $data['total'])
            return 0;

        if (($data['currentPage'] * $data['perPage']) > $data['total'])
            return $data['total'];

        return ($data['currentPage'] * $data['perPage']);
    }

    public function getTotalCount($data)
    {
        return $data['total'];
    }

    /**
     * @return array
     */
    public function getPaginationDropDown() {

        $data = [];

        for ($x = 1; $x <= $this->page_dropdown; $x++) {

            $data[$this->pagination() * $x] = $this->pagination() * $x;

        }

        return $data;

    }

}