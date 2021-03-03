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
use ke\builder\decoration\Border;
use ke\builder\Html;

/**
 * 容器
 *
 * @method $this withBackgroundColor(string $color) 设置背景颜色
 * @method $this withPadding(int $left, int $top = null, int $right = null, int $bottom = null) 设置内间距
 * @method $this withMargin(int $left, int $top = null, int $right = null, int $bottom = null) 设置外间距
 * @method $this withBorder(Border $border) 设置边框
 * @method $this withLayout(bool $val) 开启布局
 */
class Container extends Component
{
    use ComponentChildren;

    public function getStyle()
    {
        $list = [];

        if (isset($this->options['background_color'])) {
            $list[] = 'background-color:' . $this->options['background_color'][0];
        }
        if (isset($this->options['padding'])) {
            $list[] = 'padding:' . implode(' ', array_map(function ($str) {
                    return $str . 'px';
                }, $this->options['padding']));
        }
        if (isset($this->options['margin'])) {
            $list[] = 'margin:' . implode(' ', array_map(function ($str) {
                    return $str . 'px';
                }, $this->options['margin']));
        }
        if (isset($this->options['border'])) {
            /** @var Border $border */
            $border = $this->options['border'][0];
            $list[] = $border->getStyle();
        }
        return implode(';', $list);
    }


    public function build()
    {
        $html = new Html();
        $html->withTag('div', $this->id);
        $style = $this->getStyle();
        if ($style) {
            $html->withAttr('style', $style);
        }
        $layout = $this->options['layout'][0] ?? false;
        if ($layout) {
            $html->withClass('layui-container');
        }
        $html->withValue($this->buildComponent());

        return $html;
    }

}
