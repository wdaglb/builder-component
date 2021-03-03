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
 * 表单元素
 *
 * @method $this withLabel(string $value) 设置标签文本
 * @method $this withBlock(bool $value) 设置是否块级元素
 */
class FormItem extends Component
{
    use ComponentChildren;

    protected $options = [
    ];


    public function build()
    {
        $html = new Html('div', $this->id);
        $html->withClass('layui-form-item');

        $str = $this->buildComponent();

        $content = '';

        $labelText = $this->options['label'][0] ?? '';
        if ($labelText) {
            $label = new Html('div');
            $label->withClass('layui-form-label');
            $label->withValue($labelText);
            $content .= $label->toString();
        }

        $block = $this->options['block'][0] ?? false;
        $value = new Html('div');
        $value->withClass('layui-input-' . ($block ? 'block' : 'inline'));
        $value->withValue($str);
        $content .= $value->toString();


        $html->withValue($content);

        return $html;
    }

}
