<?php
/*
 * +----------------------------------------------------------------------
 * | Builder Admin
 * +----------------------------------------------------------------------
 * | Author: King east <1207877378@qq.com>
 * +----------------------------------------------------------------------
 */

namespace ke\builder;


class Html
{
    protected $tagName = '';

    protected $value = null;

    protected $attrs = [];

    protected $class = [];


    public function __construct($tagName = '', $id = '')
    {
        $this->tagName = $tagName;
        if ($id) {
            $this->attrs['id'] = ['value'=>$id, 'single'=>false];
        }
    }


    public function getOptions()
    {
        return [
            'tagName'=>$this->tagName,
            'value'=>$this->value,
            'attrs'=>$this->attrs,
            'class'=>$this->class
        ];
    }


    public function withTag($name)
    {
        $this->tagName = $name;

        return $this;
    }


    public function withId($value)
    {
        $this->attrs['id'] = [
            'value'=>$value,
            'single'=>false,
        ];

        return $this;
    }


    /**
     * @param string $name
     * @param string $value
     * @param false $single 是否使用单引号
     * @return $this
     */
    public function withAttr($name, $value, $single = false)
    {
        $this->attrs[$name] = [
            'value'=>$value,
            'single'=>$single,
        ];
        return $this;
    }


    public function withClass($name)
    {
        $this->class[] = $name;
        return $this;
    }


    public function withValue($value)
    {
        $this->value = $value;
        return $this;
    }


    protected function getValue($value)
    {
        if (is_array($value)) {
            $content = '';
            foreach ($value as $item) {
                $content .= $this->getValue($item);
            }
            return $content;
        }
        if (is_callable($value)) {
            return call_user_func($value);
        }
        if ($value instanceof Html) {
            return $value->toString();
        }
        if ($value instanceof Component) {
            return $value->render();
        }
        return $value;
    }


    public function toString()
    {
        $attr = '';
        foreach ($this->attrs as $name=>$value) {
            if ($value['value'] != '') {
                $quota = $value['single'] ? '\'' : '"';
                $attr .= ' ' . $name . '=' . $quota . $value['value'] . $quota;
            } else {
                $attr .= ' ' . $name;
            }
        }

        $class = '';
        if (count($this->class)) {
            $temps = [];
            foreach ($this->class as $name) {
                $temps[] = $name;
            }
            $class = ' class="' . implode(' ', $temps) . '"';
        }

        $value = $this->getValue($this->value);
        if (!is_null($value)) {
            return '<' . $this->tagName . $attr . $class . '>' . $value . '</' . $this->tagName . '>';
        }
        return '<' . $this->tagName . $attr. $class . ' />';
    }

}
