<?php
/*
 * +----------------------------------------------------------------------
 * | Builder Admin
 * +----------------------------------------------------------------------
 * | Author: King east <1207877378@qq.com>
 * +----------------------------------------------------------------------
 */

namespace ke\builder\components;


use ke\builder\Component;
use ke\builder\Context;
use ke\builder\response\ListResponse;
use ke\builder\exceptions\Exception;
use ke\builder\Html;

/**
 * 表格
 * @method $this withColumns(array $cols = []) 配置列
 * @method $this withLoad(callable $callback) 数据获取回调
 */
class Table extends Component
{
    public function __construct(string $id)
    {
        parent::__construct();

        $this->id = $id;
    }

    public function load()
    {
        $res = call_user_func($this->options['load'][0], $this->request->get());
        if (!($res instanceof ListResponse)) {
            throw new Exception('table: load return no ListResponse');
        }
        return $res;
    }

    public function build()
    {
        if (!isset($this->options['columns'])) {
            throw new Exception('columns is null');
        }
        if (!isset($this->options['load'])) {
            throw new Exception('load is null');
        }
        Context::addedModule('k_table');
        $html = new Html('table', $this->id);
        $html->withAttr('lay-filter', $this->id);
        $html->withAttr('lay-data', json_encode([
            'url'=>$this->request->url(),
            'page'=>true,
            'where'=>[
                'component_id'=>$this->id,
            ],
        ]), true);

        $columns = [];
        foreach ($this->options['columns'][0] as $column) {
            $text = $column['text'];
            unset($column['text']);
            $columns[] = (new Html('th'))
                ->withAttr('lay-data', json_encode($column), true)
                ->withValue($text);
        }
        $html->withValue([
            (new Html('thead'))->withValue([
                (new Html('tr'))->withValue($columns)
            ])
        ]);
        return $html;
    }

}
