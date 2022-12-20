<?php

namespace Yuyue8\Tpcores\basic;

use think\queue\Job;

/**
 * 消息队列基类
 * Class BaseJobs
 * @package Yuyue8\Tpcores\basic;
 */
abstract class BaseJobs
{
    protected $queueName = '';
    
    /**
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
        $this->fire(...$arguments);
    }

    /**
     * 运行消息队列
     * @param Job $job
     * @param $data
     */
    public function fire(Job $job, $data): void
    {
        $action     = $data['do'] ?? 'doJob';//任务名
        $infoData   = $data['data'] ?? [];//执行数据
        $errorCount = $data['errorCount'] ?? 0;//最大错误次数

        try {
            $this->runJob($action, $job, $infoData, $errorCount);
        } catch (\Throwable $e) {
            $job->delete();
        }
    }

    /**
     * 执行队列
     * @param string $action
     * @param Job $job
     * @param array $infoData
     * @param int $errorCount
     */
    protected function runJob(string $action, Job $job, array $infoData, int $errorCount = 3)
    {

        $action = method_exists($this, $action) ? $action : 'handle';
        if (!method_exists($this, $action)) {
            $job->delete();
        }

        if ($this->{$action}(...$infoData)) {
            //删除任务
            $job->delete();
        } else {
            if ($job->attempts() >= $errorCount && $errorCount) {
                //删除任务
                $job->delete();
            } else {
                //从新放入队列
                $job->release();
            }
        }

    }
}
