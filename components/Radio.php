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
use ke\builder\ComponentChildren;
use ke\builder\exceptions\Exception;
use ke\builder\Html;

/**
 * 单选框
 *
 * @method $this withName(string $text) 设置单选框名称
 * @method $this withValue(mixed $value) 设置单选框value
 * @method $this withOptions(array $options) 设置单选框选项
 */
class Radio extends Component
{
    public function build()
    {
        if (!isset($this->options['name'])) {
            throw new Exception('radio.name is null');
        }
        if (!isset($this->options['options'])) {
            throw new Exception('radio.options is null');
        }
        $checkedValue = $this->options['value'][0] ?? null;

        $name = $this->options['name'][0];
        $content = [];
        foreach ($this->options['options'][0] as $value=>$text) {
            $html = new Html('input');
            $html->withAttr('type', 'radio');
            $html->withAttr('name', $name);
            $html->withAttr('title', $text);
            $html->withAttr('value', $value);
            if (!is_null($checkedValue) && $checkedValue == $value) {
                $html->withAttr('checked', '');
            }
            $content[] = $html;
        }

        return (new Html('div', $this->id))->withValue($content);
    }

}
