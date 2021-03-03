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
use ke\builder\exceptions\Exception;
use ke\builder\Html;

/**
 * 树形组件
 * @method $this withData(array $data) 设置树数据
 * @method $this withCheckbox(bool $val) 是否显示复选框
 * @method $this withEdit($val) 是否开启节点的操作图标
 */
class Tree extends Component
{
    public function __construct(string $id)
    {
        parent::__construct();

        $this->id = $id;
    }

    public function build()
    {
        if (!isset($this->options['data'])) {
            throw new Exception('tree.data is null');
        }
        Context::addedModule('k_tree');

        $html = new Html('div', $this->id);
        $html->withAttr('id', $this->id);
        $html->withAttr('data-tree', json_encode([
            'data'=>$this->options['data'][0],
            'edit'=>$this->options['edit'][0] ?? false,
            'showCheckbox'=>$this->options['checkbox'][0] ?? false,
        ]), true);
        $html->withValue('');
        return $html;
    }

}
