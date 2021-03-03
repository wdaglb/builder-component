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
use ke\builder\exceptions\Exception;
use ke\builder\Html;

/**
 * 开关
 *
 * @method $this withName(string $text) 设置选择框名称
 * @method $this withChecked(bool $val) 设置是否选中
 */
class Switchers extends Component
{
    public function build()
    {
        if (!isset($this->options['name'])) {
            throw new Exception('switchers.name is null');
        }

        $html = new Html('input', $this->id);

        $html->withAttr('name', $this->options['name'][0]);
        $html->withAttr('type', 'checkbox');
        $html->withAttr('lay-skin', 'switch');
        if (!empty($this->options['checked'][0])) {
            $html->withAttr('checked', '');
        }

        return $html;
    }

}
