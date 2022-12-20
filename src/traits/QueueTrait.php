<?php

namespace Yuyue8\Tpcores\traits;

use Yuyue8\Tpcores\utils\Queue;

/**
 * 快捷加入消息队列
 * Trait QueueTrait
 * @package cores\traits
 */
trait QueueTrait
{
    /**
     * 列名
     * @return string
     */
    protected static function queueName()
    {
        return (new \ReflectionClass(__CLASS__))->getShortName();
    }

    /**
     * 加入队列
     * @param array|string|int $action
     * @param int|null $secs
     * @param array $data
     * @return mixed
     */
    public static function dispatch($action, array $data = [], string $queueName = null)
    {
        $queue = Queue::instance()->job(__CLASS__);
        if (is_array($action)) {
            $queue->data(...$action);
        } else if (is_string($action)) {
            $queue->do($action)->data(...$data);
        }
        if ($queueName) {
            $queue->setQueueName($queueName);
        } else if (self::queueName()) {
            $queue->setQueueName(self::queueName());
        }
        return $queue->push();
    }

    /**
     * 延迟加入消息队列
     * @param int $secs
     * @param $action
     * @param array $data
     * @return mixed
     */
    public static function dispatchSece(int $secs, $action, array $data = [], string $queueName = null)
    {
        $queue = Queue::instance()->job(__CLASS__)->secs($secs);
        if (is_array($action)) {
            $queue->data(...$action);
        } else if (is_string($action)) {
            $queue->do($action)->data(...$data);
        }
        if ($queueName) {
            $queue->setQueueName($queueName);
        } else if (self::queueName()) {
            $queue->setQueueName(self::queueName());
        }
        return $queue->push();
    }

    /**
     * 加入小队列
     * @param string $do
     * @param array $data
     * @param int|null $secs
     * @return mixed
     */
    public static function dispatchDo(string $do, array $data = [], int $secs = null,int $errorCount = 3, string $queueName = null)
    {
        $queue = Queue::instance()->job(__CLASS__)->do($do);
        if ($secs) {
            $queue->secs($secs);
        }
        if($errorCount){
            $queue->errorCount($errorCount);
        }
        if ($data) {
            $queue->data(...$data);
        }
        if ($queueName) {
            $queue->setQueueName($queueName);
        } else if (self::queueName()) {
            $queue->setQueueName(self::queueName());
        }
        return $queue->push();
    }

}
