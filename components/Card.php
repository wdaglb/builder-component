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
 * 卡片
 * @method $this withTitle(string $text) 设置标题
 */
class Card extends Component
{
    use ComponentChildren;

    public function build()
    {
        if (!isset($this->options['title'])) {
            throw new Exception('card.title is null');
        }

        $html = new Html('div', $this->id);
        $html->withClass('layui-card');
        $html->withValue([
            (new Html('div'))->withClass('layui-card-header')->withValue($this->options['title'][0]),
            (new Html('div'))->withClass('layui-card-body')->withValue($this->buildComponent()),
        ]);

        return $html;
    }

}
