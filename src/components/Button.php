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
 * 按钮
 *
 * @method $this withText(string $text) 设置按钮文本
 * @method $this withTheme(string $theme) 设置按钮主题
 * @method $this withType(string $type) 设置按钮类型
 * @method $this withSize(string $size) 设置按钮大小
 */
class Button extends Component
{
    const TYPE_BUTTON = 'button';

    const TYPE_SUBMIT = 'submit';

    const TYPE_RESET = 'reset';

    /** 默认 */
    const THEME_DEFAULT = '';

    /** 原始 */
    const THEME_PRIMARY = 'primary';

    /** 百搭 */
    const THEME_NORMAL = 'normal';

    /** 暖色 */
    const THEME_WARM = 'warm';

    /** 警告 */
    const THEME_DANGER = 'danger';

    /** 禁用 */
    const THEME_DISABLED = 'disabled';

    /** 大型 */
    const SIZE_LG = 'lg';

    /** 正常 */
    const SIZE_DEFAULT = '';

    /** 小型 */
    const SIZE_SM = 'sm';

    /** 迷你 */
    const SIZE_XS = 'xs';

    protected $options = [
        'theme'=>[self::THEME_DEFAULT],
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
        if (!isset($this->options['text'])) {
            throw new Exception('button.text is null');
        }
        $type = $this->options['type'][0] ?? null;
        $theme = $this->options['theme'][0] ?? self::THEME_DEFAULT;
        $size = $this->options['size'][0] ?? self::SIZE_DEFAULT;

        $html = new Html('button', $this->id);
        if (!is_null($type)) {
            $html->withAttr('type', $type);

            if ($type == self::TYPE_SUBMIT) {
                $html->withAttr('lay-submit', '');
            }
        }

        $style = $this->getStyle();
        if ($style) {
            $html->withAttr('style', $style);
        }
        $html->withValue($this->options['text'][0]);

        $html->withClass('layui-btn');

        if ($theme) {
            $html->withClass('layui-btn-' . $theme);
        }

        if ($size) {
            $html->withClass('layui-btn-' . $size);
        }

        return $html;
    }

}
