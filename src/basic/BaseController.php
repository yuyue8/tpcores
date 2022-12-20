<?php
declare (strict_types = 1);

namespace Yuyue8\Tpcores\basic;

use think\facade\App;

/**
 * 控制器基础类
 */
abstract class BaseController
{
    /**
     * Request实例
     * @var \think\Request
     */
    protected $request;

    /**
     * 应用实例
     * @var \think\App
     */
    protected $app;

    /**
     * 构造方法
     * @access public
     * @param  App  $app  应用对象
     */
    public function __construct(App $app)
    {
        $this->app     = $app;
        $this->request = app('request');

        // 控制器初始化
        $this->initialize();
    }

    // 初始化
    protected function initialize()
    {}

}