<?php
/*
 * +----------------------------------------------------------------------
 * | Builder Admin
 * +----------------------------------------------------------------------
 * | Author: King east <1207877378@qq.com>
 * +----------------------------------------------------------------------
 */

namespace ke\builder;


/**
 * 组件是否有下级
 * Trait ComponentChildren
 * @package ke\builder
 */
trait ComponentChildren
{

    /**
     * @var Component[]
     */
    public $components = [];


    public function addComponent(Component $component)
    {
        $this->components[] = $component;
        return $this;
    }


    protected function buildComponent(callable $callback = null): string
    {
        $contents = '';
        if (count($this->components)) {
            foreach ($this->components as $component) {
                $str = $component->render();
                $contents .= PHP_EOL . ($callback ? call_user_func_array($callback, [$str]) : $str) . PHP_EOL;
            }
        }

        return $contents;
    }

}
