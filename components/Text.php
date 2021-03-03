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
 * 文本
 * @method $this withContent(string $text) 设置文本内容
 * @method $this withColor(string $color) 设置文本颜色
 */
class Text extends Component
{
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
        if (!isset($this->options['content'])) {
            throw new Exception('text.content is null');
        }
        $html = new Html('span', $this->id);
        $style = $this->getStyle();
        if ($style) {
            $html->withAttr('style', $style);
        }
        $html->withValue($this->options['content'][0]);
        return $html;
    }

}
