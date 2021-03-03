<?php
/*
 * +----------------------------------------------------------------------
 * | Builder Admin
 * +----------------------------------------------------------------------
 * | Author: King east <1207877378@qq.com>
 * +----------------------------------------------------------------------
 */

namespace ke\builder\response;


class DataResponse
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }


    public function getData()
    {
        return $this->data;
    }

}
