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
 * 按钮组
 */
class ButtonGroup extends Component
{
    use ComponentChildren;

    public function build()
    {
        $html = new Html('div', $this->id);

        $html->withValue($this->buildComponent());

        $html->withClass('layui-btn-group');

        return $html;
    }

}
