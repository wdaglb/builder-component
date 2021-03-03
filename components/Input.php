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
 * 输入框
 *
 * @method $this withName(string $name) 设置输入框名称
 * @method $this withType(string $type) 设置输入框类型
 * @method $this withValue(string $value) 设置内容
 * @method $this withPlaceholder(string $value)
 * @method $this withAutocomplete(string $value)
 * @method $this withVerify(string $str) 设置验证器
 */
class Input extends Component
{
    /** 文本 */
    const TYPE_TEXT = 'text';

    /** 密码 */
    const TYPE_PASSWORD = 'password';

    /** 文本域 */
    const TYPE_TEXTAREA = 'textarea';

    protected $options = [
        'autocomplete'=>['off'],
    ];

    public function getStyle()
    {
        $list = [];

        if (isset($this->options['color'])) {
            $list[] = 'color:' . $this->options['color'][0];
        }
        return implode(';', $list);
    }


    public function build()
    {
        if (!isset($this->options['name'])) {
            throw new Exception('input.name is null');
        }
        $type = $this->options['type'][0] ?? self::TYPE_TEXT;
        $value = $this->options['value'][0] ?? null;

        $html = new Html();
        $html->withAttr('id', $this->id);
        if ($type === 'textarea') {
            $html->withTag('textarea');
            $html->withAttr('class', 'layui-textarea');
            $html->withValue($value ?? '');
        } else {
            $html->withTag('input');
            $html->withAttr('class', 'layui-input');
            $html->withAttr('value', $value);
        }
        if (isset($this->options['value'])) {
            unset($this->options['value']);
        }
        if (isset($this->options['verify'])) {
            $html->withAttr('lay-verify', $this->options['verify'][0]);
            unset($this->options['verify']);
        }

        $style = $this->getStyle();
        if ($style) {
            $html->withAttr('style', $style);
        }
        foreach ($this->options as $name=>$value) {
            $html->withAttr($name, $value[0]);
        }
        return $html;
    }

}
