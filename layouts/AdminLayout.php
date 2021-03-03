<?php
/*
 * +----------------------------------------------------------------------
 * | Builder Admin
 * +----------------------------------------------------------------------
 * | Author: King east <1207877378@qq.com>
 * +----------------------------------------------------------------------
 */

namespace ke\builder\layouts;


use ke\builder\Component;
use ke\builder\ComponentChildren;
use ke\builder\components\Icon;
use ke\builder\Context;
use ke\builder\exceptions\Exception;
use ke\builder\Html;

/**
 * 后台布局
 * @method $this withMenu(array $menus) 设置菜单
 * @method $this withTitle(string $title) 设置页面标题
 * @method $this withHomeUrl(string $url) 设置默认首页
 * @method $this withRightHeaderInfo(array $info) 设置右上角头部信息
 */
class AdminLayout extends Component
{
    use ComponentChildren;

    /**
     * @return Html
     * @throws Exception
     */
    public function build()
    {
        Context::addedModule('admin_layout');
        if (!isset($this->options['menu'])) {
            throw new Exception('adminLayout.menu is null');
        }
        if (!isset($this->options['home_url'])) {
            throw new Exception('adminLayout.home_url is null');
        }
        if (!isset($this->options['right_header_info'])) {
            throw new Exception('adminLayout.right_header_info is null');
        }
        $menu = $this->createSide($this->options['menu'][0]);
        $header = $this->createHeader();
        $body = $this->createBody();

        $container = new Html('div');

        $container->withValue([$menu, $header, $body]);

        return $container;
    }


    /**
     * 创建侧边栏
     * @param $menu
     * @return Html
     */
    protected function createSide($menu): Html
    {
        // 菜单
        $content = '';

        foreach ($menu as $m) {
            $a = $this->renderMenuLink($m['text'], $m['url'] ?? 'javascript:;', $m['icon'] ?? '');

            $li = new Html('li');
            $li->withClass('layui-nav-item');

            $hasChildren = isset($m['children']) &&
                is_array($m['children']) &&
                count($m['children']);

            if (!$hasChildren) {
                $a->withAttr('target', 'admin-container');
            }

            $children = [$a];
            if ($hasChildren) {
                if (!empty($m['opend'])) {
                    // 默认展开
                    $li->withClass('layui-nav-itemed');
                }
                $children[] = $this->renderChild($m['children']);
            }
            $li->withValue($children);

            $content .= $li->toString();
        }

        $menu = new Html('ul');
        $menu->withAttr('id', 'admin-layout-menu');
        $menu->withClass('layui-nav layui-nav-tree');
        $menu->withValue($content);

        $scroll = new Html('div');
        $scroll->withValue($menu);
        $scroll->withClass('layui-side-scroll');

        // 加上logo标题
        $title = new Html('div');
        $title->withClass('ke-side-logo');
        $title->withValue($this->options['title'][0] ?? 'Builder Admin');

        $container = new Html('div');
        $container->withClass('ke-side');
        $container->withValue([
            $title,
            $scroll
        ]);

        return $container;
    }


    /**
     * 渲染子菜单
     * @param $menu
     * @return Html
     */
    protected function renderChild($menu): Html
    {
        $dl = new Html('dl');
        $dl->withClass('layui-nav-child');

        $children = [];
        foreach ($menu as $m) {
            $dd = new Html('dd');
            $a = $this->renderMenuLink($m['text'], $m['url']);
            $a->withAttr('target', 'admin-container');

            $dd->withValue($a);
            $children[] = $dd;
        }
        $dl->withValue($children);

        return $dl;
    }


    /**
     * 渲染菜单链接项
     * @param string $text 文本
     * @param string $url 连接
     * @param string $icon 图标
     * @return Html
     */
    protected function renderMenuLink(string $text, string $url, string $icon = ''): Html {
        $a = new Html('a');
        $a->withAttr('href', $url);

        if ($icon === '') {
            $a->withValue($text);
        } else {
            $a->withValue([
                (new Icon($icon)),
                $text
            ]);
        }
        return $a;
    }


    /**
     * 创建头部
     * @return Html
     */
    protected function createHeader(): Html
    {
        $setting = $this->options['right_header_info'][0];
        $rightList = [
            (new Html('li'))
                ->withClass('layui-nav-item')
                ->withValue([
                    (new Html('a'))
                        ->withAttr('href', 'javascript:;')
                        ->withValue([
                            (new Html('img'))
                                ->withAttr('src', $setting['avatar'])
                                ->withClass('layui-nav-img'),
                            $setting['username'],
                        ]),


                    (new Html('dl'))
                        ->withClass('layui-nav-child')
                        ->withValue(array_map(function ($item) {
                            $a = new Html('a');
                            $a->withAttr('href', $item['url']);
                            $a->withAttr('target', 'admin-container');
                            if (isset($item['ajax'])) {
                                $a->withAttr('k-ajax', $item['ajax']);
                            }
                            $a->withValue($item['text']);

                            $dd = new Html('dd');
                            $dd->withValue($a);
                            return $dd;
                        }, $setting['menus']))
                ]
            ),

        ];


        $right = new Html('ul');
        $right->withClass('layui-nav layui-layout-right');
        $right->withAttr('lay-filter', 'top-header-right');
        $right->withAttr('style', 'margin-right: 20px');
        $right->withValue($rightList);

        $container = new Html('div');
        $container->withClass('ke-header');
        $container->withValue([$right]);
        return $container;
    }


    /**
     * 创建内容
     * @return Html
     */
    protected function createBody(): Html
    {
        $container = new Html('div');

        $container->withClass('ke-body');
        $container->withValue([
            $this->createTabs(),
            (new Html('div'))
                ->withClass('ke-tab-content')
                ->withValue([
                    (new Html('div'))
                        ->withClass('ke-tab-item')
                        ->withValue([
                            (new Html('iframe'))
                                ->withAttr('id', 'admin-container')
                                ->withAttr('name', 'admin-container')
                                ->withClass('ke-content')
                                ->withAttr('src', url($this->options['home_url'][0]))
                                ->withValue('')
                        ])
                ])
        ]);

        return $container;
    }


    /**
     * 创建选项卡
     * @return Html
     */
    protected function createTabs(): Html
    {
        $container = new Html('div', 'admin-layout-tabs');

        $container->withClass('ke-body-tabs');

        $container->withValue([
            (new Html('div'))
                ->withClass('layui-icon layui-icon-prev ke-body-tab-icon ke-body-tab-prev')
                ->withValue(''),
            (new Html('div'))
                ->withClass('layui-icon layui-icon-next ke-body-tab-icon ke-body-tab-next')
                ->withValue(''),
            (new Html('div'))
                ->withClass('layui-icon layui-icon-down ke-body-tab-icon ke-body-tab-down')
                ->withValue([
                    (new Html('ul'))
                        ->withClass('layui-nav')
                        ->withAttr('lay-filter', 'admin-layout-tabs-nav')
                        ->withValue([
                            (new Html('li'))
                                ->withAttr('lay-unselect', '')
                                ->withClass('layui-nav-item')
                                ->withValue([
                                    (new Html('a'))
                                    ->withAttr('href', 'javascript:;')
                                    ->withValue((new Html('span'))
                                        ->withClass('layui-nav-more')
                                        ->withValue('')
                                    ),

                                    (new Html('dl'))
                                        ->withClass('layui-nav-child layui-anim-fadein layui-anim layui-anim-upbit')
                                        ->withValue([
                                            (new Html('dd'))
                                                ->withValue((new Html('a'))
                                                    ->withAttr('href', 'javascript:;')
                                                    ->withAttr('event', 'closeCurrent')
                                                    ->withValue('关闭当前标签页')
                                                ),
                                            (new Html('dd'))
                                                ->withValue((new Html('a'))
                                                    ->withAttr('href', 'javascript:;')
                                                    ->withAttr('event', 'closeOther')
                                                    ->withValue('关闭其它标签页')
                                                ),
                                            (new Html('dd'))
                                                ->withValue((new Html('a'))
                                                    ->withAttr('href', 'javascript:;')
                                                    ->withAttr('event', 'closeAll')
                                                    ->withValue('关闭所有标签页')
                                                )
                                        ])
                                ]),
                        ]),
                ]),
            (new Html('div'))
                ->withClass('layui-tab layui-tab-brief')
                ->withAttr('lay-filter', 'admin-layout-tabs')
                ->withAttr('lay-allowClose', 'true')
                ->withAttr('lay-unauto', '')
                ->withValue([
                    (new Html('ul'))
                        ->withClass('layui-tab-title')
                        ->withValue([
                            (new Html('li'))
                                ->withClass('layui-this')
                                ->withAttr('lay-id', '/')
                                ->withValue('首页'),
                        ])
                ])
        ]);

        return $container;
    }

}
