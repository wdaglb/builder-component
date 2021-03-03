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
 * 组件工厂
 * @method static \ke\builder\components\Blockquote Blockquote() 引用区块
 * @method static \ke\builder\components\Button Button() 按钮
 * @method static \ke\builder\components\ButtonGroup ButtonGroup() 按钮
 * @method static \ke\builder\components\Card Card() 卡片
 * @method static \ke\builder\components\Checkbox Checkbox() 复选框
 * @method static \ke\builder\components\Container Container() 容器
 * @method static \ke\builder\components\Echarts Echarts(array $initOption) 图表
 * @method static \ke\builder\components\Fieldset Fieldset() 字段集区块
 * @method static \ke\builder\components\Form Form(string $name) 表单
 * @method static \ke\builder\components\FormItem FormItem() 表单组
 * @method static \ke\builder\components\Hr Hr() 横线
 * @method static \ke\builder\components\Icon Icon(string $name) 图标
 * @method static \ke\builder\components\Input Input() 输入框
 * @method static \ke\builder\components\Link Link() 链接
 * @method static \ke\builder\components\Radio Radio() 单选框
 * @method static \ke\builder\components\Select Select() 选择框
 * @method static \ke\builder\components\Switchers Switchers() 开关
 * @method static \ke\builder\components\Table Table(string $id) 表格
 * @method static \ke\builder\components\Text Text() 文字
 * @method static \ke\builder\components\Tinymce Tinymce(string $name) 富文本编辑器
 * @method static \ke\builder\components\Tree Tree(string $id) 树形结构
 */
class ComponentFactory
{
    public static function __callStatic($name, $arguments)
    {
        $class = '\\ke\\builder\\components\\' . $name;

        return new $class(...$arguments);
    }
}
