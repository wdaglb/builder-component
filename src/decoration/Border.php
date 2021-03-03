<?php
/*
 * +----------------------------------------------------------------------
 * | Builder Admin
 * +----------------------------------------------------------------------
 * | Author: King east <1207877378@qq.com>
 * +----------------------------------------------------------------------
 */

namespace ke\builder\decoration;


use ke\builder\Component;

/**
 * Class Border
 * @package ke\builder\decoration
 *
 * @method $this withStyle(string $style) 边框样式
 * @method $this withWidth(int $width) 边框宽度
 * @method $this withColor(string $color) 边框颜色
 * @method $this withRadius(int $radius) 圆角
 */
class Border extends Component
{
    /** 实线 */
    const STYLE_SOLID = 'solid';

    /** 双线 */
    const STYLE_DOUBLE = 'double';

    /** 虚线 */
    const STYLE_DASHED = 'dashed';

    /** 点状 */
    const STYLE_DOTTED = 'dotted';

    /** 无边框 */
    const STYLE_NONE = 'none';


    protected $options = [
        'style'=>'none',
        'width'=>0,
        'color'=>'#000000',
        'radius'=>0,
    ];

    public function getStyle()
    {
        $style = 'border:' . $this->options['style'][0] . ' ' . $this->options['width'][0] . 'px ' . $this->options['color'][0];

        $style .= ';border-radius:' . $this->options['radius'][0] . 'px';

        return $style;
    }
}
