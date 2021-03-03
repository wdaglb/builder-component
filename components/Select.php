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
 * 选择框
 *
 * @method $this withName(string $text) 设置选择框名称
 * @method $this withValue(mixed $value) 设置选择框value
 * @method $this withOptions(array $options) 设置选择框选项
 * @method $this withVerify(string $str) 设置验证器
 */
class Select extends Component
{
    protected $options = [
    ];


    public function build()
    {
        if (!isset($this->options['name'])) {
            throw new Exception('select.name is null');
        }
        if (!isset($this->options['options'])) {
            throw new Exception('select.options is null');
        }
        $checkedValue = $this->options['value'][0] ?? null;

        $html = new Html('select', $this->id);

        $html->withAttr('name', $this->options['name'][0]);
        if (isset($this->options['verify'])) {
            $html->withAttr('lay-verify', $this->options['verify'][0]);
            unset($this->options['verify']);
        }

        $content = '';
        foreach ($this->options['options'][0] as $value=>$text) {
            $opt = new Html('option');
            $opt->withAttr('value', $value);
            $opt->withValue($text);
            if (!is_null($checkedValue) && $checkedValue == $value) {
                $opt->withAttr('selected', '');
            }
            $content .= $opt->toString() . PHP_EOL;
        }
        $html->withValue(PHP_EOL . $content);

        return $html;
    }

}
