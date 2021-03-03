<?php
/*
 * +----------------------------------------------------------------------
 * | Builder Admin
 * +----------------------------------------------------------------------
 * | Author: King east <1207877378@qq.com>
 * +----------------------------------------------------------------------
 */

namespace ke\builder;


use ke\builder\constraint\EngineConfig;
use ke\builder\exceptions\Exception;
use ke\builder\response\DataResponse;
use ke\builder\response\ListResponse;
use think\Container;
use think\facade\App;
use think\Request;
use think\Response;

class Engine extends Response
{
    protected $config;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Component[]
     */
    protected $components = [];

    /**
     * @var string
     */
    protected $title = 'Builder Admin';

    /**
     * 是否开启编译缓存 正式部署环境下建议开启
     * @var bool
     */
    protected $cache = false;

    public function __construct(EngineConfig $config)
    {
        $this->config = $config->getData();
        $this->request = Container::pull(Request::class);
    }


    public function setTitle(string $title)
    {
        $this->title = $title;
        return $this;
    }


    /**
     * 开启编译缓存
     * @return $this
     */
    public function enabledCache()
    {
        $this->cache = true;
        return $this;
    }


    public function addComponent(Component $component)
    {
        $this->components[] = $component;
        return $this;
    }


    protected function loadAssets($src, $version)
    {
        return sprintf('%s/%s?v=%s', $this->config['path'], $src, $version);
    }


    /**
     * 取得组件回调值
     * @param Component $component
     * @return array
     */
    protected function resolveResponse(Component $component)
    {
        try {
            if (!method_exists($component, 'load')) {
                throw new Exception('load function is null');
            }
            $result = ['code'=>0];
            $res = call_user_func([$component, 'load']);
            if ($res instanceof ListResponse) {
                $result['data'] = $res->getItems();
                $result['count'] = $res->getTotal();
            } else if ($res instanceof DataResponse) {
                $result['data'] = $res->getData();
            } else if ($res) {
                $result = array_merge($result, $res);
            }
            return $result;
        } catch (Exception $e) {
            return [
                'code'=>1,
                'msg'=>$e->getMessage()
            ];
        } catch (\Throwable $e) {
            return [
                'code'=>1,
                'msg'=>$e->getMessage(),
            ];
        }
    }


    /**
     * 遍历符合id的组件
     * @param $components
     * @param $componentId
     * @return false|string|null|array
     */
    protected function resolveComponent($components, $componentId)
    {
        foreach ($components as $component) {
            if ($component->id == $componentId) {
                return $this->resolveResponse($component);
            } else if (!empty($component->components)) {
                $res = $this->resolveComponent($component->components, $componentId);
                if ($res) {
                    return $res;
                }
            }
        }

        $this->code(404);
        return null;
    }


    protected function output($data): string
    {
        if ($this->request->isAjax()) {
            $this->contentType('application/json');
            $componentId = $this->request->get('component_id');
            return json_encode($this->resolveComponent($this->components, $componentId));
        }

        return $this->resolve();
    }


    protected function resolve()
    {
        $version = $this->config['version'];
        if ($this->config['debug']) {
            $version .= '.' . time();
        }

        $this->contentType('text/html');

        $content = '';

        $children = [];

        $content .= '<!DOCTYPE html>';
        $children[] = (new Html('head'))->withValue([
            (new Html('meta'))->withAttr('charset', 'UTF-8'),
            (new Html('meta'))->withAttr('name', 'viewport')
                ->withAttr('content', 'width=device-width, initial-scale=1, maximum-scale=1'),
            (new Html('title'))->withValue($this->title),
            (new Html('link'))->withAttr('rel', 'stylesheet')
                ->withAttr('href', $this->loadAssets('builder/libs/layui/css/layui.css', $version)),
            (new Html('link'))->withAttr('rel', 'stylesheet')
                ->withAttr('href', $this->loadAssets('builder/css/app.css', $version)),
        ]);

        $body = (new Html('body'))->withValue(function () use($version, &$globalJs, &$globalPluginJs) {
            $content = '';

            foreach ($this->components as $component) {
                $content .= $component->render();
            }

            $content .= PHP_EOL . (new Html('script'))
                    ->withValue('')
                    ->withAttr('src', $this->loadAssets('builder/libs/jquery.min.js', '3.5.1'))
                    ->toString();
            $content .= PHP_EOL . (new Html('script'))
                    ->withValue('')
                    ->withAttr('src', $this->loadAssets('builder/libs/layui/layui.js', $version))
                    ->toString();
            $content .= PHP_EOL . (new Html('script'))
                    ->withValue('')
                    ->withAttr('src', $this->loadAssets('builder/utils.js', $version))
                    ->toString();

            foreach (Context::getJsList() as $src) {
                $content .= PHP_EOL . (new Html('script'))
                        ->withValue('')
                        ->withAttr('src', $this->loadAssets($src, $version))
                        ->toString();
            }
//            $content .= PHP_EOL . (new Html('script'))
//                    ->withValue('')
//                    ->withAttr('src', $this->loadAssets('builder/app.js', $version))
//                    ->toString();
            $script = '';
            $initMod = '';

            foreach (Context::getModules() as $name) {
                $script .= "'${name}',";
                $initMod .= "layui.${name};";
            }
            $content .= PHP_EOL . (new Html('script'))
                    ->withValue([
                        'var componentOptions = ' . Context::getClientOptions() . ';',
                        'layui.config({ version: \'' . ($version) . '\', base: \'' . $this->config['path'] . '/builder/\' });',
                        sprintf('layui.use([%s], function() {%s})', $script, $initMod),
                    ])
                    ->toString();

            return $content;
        });

        $children[] = $body;
        $html = new Html('html');
        $html->withAttr('lang', 'zh-CN');
        $html->withValue($children);

        $content .= PHP_EOL . $html->toString();

        $this->setCache($content);

        return $content;
    }


    protected function getCachePath()
    {
        return $this->config['cache_path'] ?: (App::getRuntimePath() . 'builder/');
    }


    protected function setCache(string $content)
    {
        $path = $this->getCachePath();
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
        file_put_contents($path . md5('21'), $content);
    }

}
