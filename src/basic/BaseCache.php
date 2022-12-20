<?php
namespace Yuyue8\Tpcores\basic;

use Closure;
use think\cache\driver\Redis;
use think\Container;
use think\facade\Cache;
use think\facade\Env;

/**
 * Class BaseCache
 * @package Yuyue8\Tpcores\basic
 */
abstract class BaseCache
{

    /**
     * 模型注入
     * @var object
     */
    protected $dao;

    /**
     * 获取redis连接
     *
     * @return Redis
     */
    public function getCache()
    {
        return Cache::store('redis');
    }

    /**
     * 如果不存在则写入缓存
     *
     * @param [type] $name
     * @param [type] $value
     * @param [type] $expire
     * @return mixed
     */
    public function remember($name, $value, $expire = 0)
    {
        if(Env::get('cache.enable',false)){
            return $this->getCache()->remember($name, $value, $expire);
        }
        if ($value instanceof Closure) {
            // 获取缓存数据
            $value = Container::getInstance()->invokeFunction($value);
        }
        return $value;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
        return call_user_func_array([$this->dao, $name], $arguments);
    }
}
