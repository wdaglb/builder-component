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
use ke\builder\exceptions\Exception;
use ke\builder\Html;

/**
 * 富文本 tinymce
 * @method $this withJs(string $src) 引入tinymce入口文件
 * @method $this withHeight(int $height) 编辑器初始高度
 * @method $this withLang(string $lang) 界面语言,默认中文
 * @method $this withImageUploadUrl(string $url) 图片上传接口, 应返回json格式 { "location": "folder/sub-folder/new-location.png" }
 */
class Tinymce extends Component
{
    protected $name = '';

    public function __construct(string $name)
    {
        parent::__construct();

        $this->name = $name;
    }

    public function build()
    {
        if (!isset($this->options['js'])) {
            throw new Exception('tinymce.js is null');
        }
        Context::addedModule('k_tinymce');
        $container = new Html('div', $this->id);

        $script = new Html('script');
        $script->withAttr('src', $this->options['js'][0]);
        $script->withValue('');

        $html = new Html('textarea');
        $html->withAttr('name', $this->name);
        $html->withAttr('k-tinymce', json_encode((object)array_filter([
            'height'=>$this->options['height'][0] ?? null,
            'lang'=>$this->options['lang'][0] ?? 'zh_CN',
            'image_upload_url'=>$this->options['image_upload_url'][0] ?? null,
        ])), true);
        $html->withValue('');

        $container->withValue($script->toString() . $html->toString());
        return $container;
    }

}
