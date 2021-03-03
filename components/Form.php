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
use ke\builder\Context;
use ke\builder\exceptions\Exception;
use ke\builder\Html;

/**
 * 表单
 * @method $this withLoad(callable $callback) 提交回调
 */
class Form extends Component
{
    use ComponentChildren;

    protected $name = '';

    public function __construct(string $name)
    {
        parent::__construct();

        $this->name = $name;
    }

    public function load()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
        } else {
            $data = $this->request->get();
        }
        return call_user_func($this->options['load'][0], $data);
    }

    public function build()
    {
        if (!isset($this->options['load'][0])) {
            throw new Exception('form.load is null');
        }
        Context::addedModule('k_form');

        $html = new Html('form', $this->id);
        $html->withClass('layui-form');

        $html->withAttr('name', $this->name);

        $html->withValue($this->buildComponent());

        return $html;
    }

}
