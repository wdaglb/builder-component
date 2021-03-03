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
 * 复选框
 *
 * @method $this withName(string $text) 设置选择框名称
 * @method $this withTitle(string $text) 设置选择框文本
 * @method $this withChecked(bool $val) 设置是否选中
 * @method $this withVerify(string $str) 设置验证器
 */
class Checkbox extends Component
{
    public function build()
    {
        if (!isset($this->options['name'])) {
            throw new Exception('checkbox.name is null');
        }

        $html = new Html('input', $this->id);

        $html->withAttr('name', $this->options['name'][0]);
        $html->withAttr('type', 'checkbox');
        $html->withAttr('title', $this->options['title'][0]);
        if (!empty($this->options['checked'][0])) {
            $html->withAttr('checked', '');
        }
        if (isset($this->options['verify'])) {
            $html->withAttr('lay-verify', $this->options['verify'][0]);
            unset($this->options['verify']);
        }

        return $html;
    }

}
