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
use ke\builder\Context;
use ke\builder\Html;

/**
 * 图表
 * @method $this withSize(int $width, int $height = 0) 设置大小
 */
class Echarts extends Component
{
    protected $initOption = [];

    public function __construct(array $initOption)
    {
        parent::__construct();

        $this->initOption = $initOption;
    }

    /**
     * 配置项
     * https://echarts.apache.org/zh/option.html
     * @param array $option
     * @return $this
     */
    public function setOption(array $option)
    {
        $this->initOption = array_merge($this->initOption, $option);
        return $this;
    }

    public function build()
    {
        Context::addedModule('k_echarts');
        Context::addedJs('builder/libs/echarts/echarts.min.js');
        $this->addClientOptions('echarts', $this->initOption);

        $container = new Html('div', $this->id);

        $width = $this->options['size'][0] ?? '500';
        $height = $this->options['size'][1] ?? $width;
        $container->withAttr('style', sprintf('display:inline-block;width:%spx;height:%spx;', $width, $height));
        $container->withValue('');

        return $container;
    }

}
