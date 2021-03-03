<?php
/*
 * +----------------------------------------------------------------------
 * | Builder Admin
 * +----------------------------------------------------------------------
 * | Author: King east <1207877378@qq.com>
 * +----------------------------------------------------------------------
 */

namespace ke\builder;


use ke\builder\exceptions\Exception;
use think\Container;
use think\facade\App;
use think\Request;
use function Symfony\Component\String\u;

class Component
{
    public $id;

    /**
     * @var Request
     */
    protected $request;

    protected $options = [];


    public function __construct()
    {
        $this->id = base64_encode(mt_rand(0, 99999) . uniqid());
        $this->request = Container::pull(Request::class);
    }


    public function __call($name, $arguments)
    {
        if (substr($name, 0, 4) === 'with') {
            $name = u(substr($name, 4))->snake()->toString();

            $this->options[$name] = $arguments;
            return $this;
        } else if (substr($name, 0, 3) === 'get') {
            $name = u(substr($name, 3))->snake()->toString();

            return $this->options[$name];
        }
        throw new Exception('method not exist: ' . $name);
    }


    protected function addClientOptions(string $group, array $options)
    {
        Context::addClientOptions($group, $this->id, $options);
    }


    /**
     * @return Html
     */
    public function build()
    {
    }


    /**
     * 渲染组件
     * @return string
     */
    public function render(): string
    {
        $html = $this->build();
        // 写进缓存
//        $root_path = App::getRuntimePath() . 'builder/';
//        if (!is_dir($root_path)) {
//            mkdir($root_path, 0755, true);
//        }
//        $filename = str_replace('\\', '_', get_class($this));
//
//        if (is_file($root_path . $filename . '.php')) {
//            return file_get_contents($root_path . $filename . '.php');
//        }
//        $content = $this->build();
//
//        file_put_contents($root_path . $filename . '.php', $content);
//
//        return $content;

        return $html->toString();
    }

}
