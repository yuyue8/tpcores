<?php
namespace Yuyue8\Tpcores\basic;

use think\Model;

/**
 * Class BaseModel
 * @package Yuyue8\Tpcores\basic
 */
class BaseModel extends Model
{

    public static $cache;

    /**
     * 写入前
     */
    public static function onBeforeWrite($model)
    {
        self::$cache->deleteAllCache($model->getWhere());
    }

    /**
     * 写入后
     */
    public static function onAfterWrite($model)
    {
        self::$cache->deleteAllCache($model->getWhere());
    }

    /**
     * 删除前
     */
    public static function onBeforeDelete($model)
    {
        self::$cache->deleteAllCache($model->getWhere());
    }
}