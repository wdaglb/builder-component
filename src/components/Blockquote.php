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
 * 引用区块
 * @method $this withContent(string $text) 设置文本内容
 * @method $this withMode(string $mode) 设置风格
 */
class Blockquote extends Component
{
    const MODE_DEFAULT = '';

    const MODE_NM = 'nm';

    public function build()
    {
        if (!isset($this->options['content'])) {
            throw new Exception('blockquote.content is null');
        }
        $mode = $this->options['mode'][0] ?? self::MODE_DEFAULT;
        $html = new Html('blockquote', $this->id);
        $html->withClass('layui-elem-quote');
        if ($mode) {
            $html->withClass('layui-quote-' . $mode);
        }
        $html->withValue($this->options['content'][0]);
        return $html;
    }

}
