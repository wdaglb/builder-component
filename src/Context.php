<?php
/*
 * +----------------------------------------------------------------------
 * | Builder Admin
 * +----------------------------------------------------------------------
 * | Author: King east <1207877378@qq.com>
 * +----------------------------------------------------------------------
 */

namespace ke\builder;


class Context
{
    private static $modules = [];

    private static $js = [];

    private static $clientOptions = [];

    /**
     * 添加模块引用
     * @param string $name
     */
    public static function addedModule(string $name): void
    {
        if (array_search($name, self::$modules) === false) {
            self::$modules[] = $name;
        }
    }

    /**
     * 返回模块引用列表
     * @return array
     */
    public static function getModules(): array
    {
        return self::$modules;
    }

    /**
     * 添加js引用
     * @param string $src
     */
    public static function addedJs(string $src): void
    {
        if (array_search($src, self::$js) === false) {
            self::$js[] = $src;
        }
    }

    /**
     * 返回js引用列表
     * @return array
     */
    public static function getJsList(): array
    {
        return self::$js;
    }

    /**
     * 添加客户端配置
     * @param string $component 组件类型
     * @param string $component_id 组件id
     * @param array $options 配置项
     */
    public static function addClientOptions(string $component, string $component_id, array $options): void
    {
        self::$clientOptions[$component][$component_id] = $options;
    }

    /**
     * 返回客户端配置
     * @param bool $toJson 是否转为json
     * @return array|string
     */
    public static function getClientOptions(bool $toJson = true)
    {
        return $toJson ? json_encode((object)self::$clientOptions) : $toJson;
    }
}