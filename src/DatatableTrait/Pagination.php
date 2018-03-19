<?php

namespace SagarYonjan\VueDatatable\DatatableTrait;

trait Pagination
{
    /**
     * @param $data
     * @return int
     */
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

    /**
     * @param $data
     * @return int
     */
    public function getPaginationEndTo($data)
    {
        $start = (($data['currentPage'] * $data['perPage']) - $data['perPage']) + 1;
        if ($start > $data['total'])
            return 0;

        if (($data['currentPage'] * $data['perPage']) > $data['total'])
            return $data['total'];

        return ($data['currentPage'] * $data['perPage']);
    }

    /**
     * @param $data
     * @return mixed
     */
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