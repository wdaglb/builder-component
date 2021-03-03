<?php
/*
 * +----------------------------------------------------------------------
 * | Builder Admin
 * +----------------------------------------------------------------------
 * | Author: King east <1207877378@qq.com>
 * +----------------------------------------------------------------------
 */

namespace ke\builder\constraint;


class EngineConfig
{
    private $data = [
        'debug'=>true,
        'path'=>'',
        'version'=>'0.0.1',
        'cache_path'=>''
    ];

    /**
     * 路径
     * @param string $str
     * @return $this
     */
    public function withPath(string $str)
    {
        $this->data['path'] = $str;
        return $this;
    }

    /**
     * 设置编译缓存路径
     * @param string $path
     * @return $this
     */
    public function withCachePath(string $path)
    {
        $this->data['cache_path'] = $path;
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }
}
