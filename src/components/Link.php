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
 * 链接
 *
 * @method $this withUrl(string $url) 设置跳转链接
 */
class Link extends Component
{
    use ComponentChildren;

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
        if (!isset($this->options['url'])) {
            throw new Exception('link.url is null');
        }
        $html = new Html('a', $this->id);

        $style = $this->getStyle();
        if ($style) {
            $html->withAttr('style', $style);
        }
        $html->withAttr('href', $this->options['url'][0]);
        $html->withValue($this->buildComponent());
        return $html;
    }

}
