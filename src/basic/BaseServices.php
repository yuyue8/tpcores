<?php
namespace Yuyue8\Tpcores\basic;

/**
 * Class BaseServices
 * @package Yuyue8\Tpcores\basic
 */
abstract class BaseServices
{
    /**
     * 模型注入
     * @var object
     */
    protected $cache;

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
        return call_user_func_array([$this->cache, $name], $arguments);
    }
}
