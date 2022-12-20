<?php
namespace Yuyue8\Tpcores\traits;

/**
 *
 * Class ErrorTrait
 * @package cores\basic
 */
trait ErrorTrait
{
    /**
     * 错误信息
     * @var string
     */
    protected $error;

    /**
     * 设置错误信息
     * @param string|null $error
     * @return bool
     */
    protected function setError(?string $error = null)
    {
        $this->error = $error ?: '未知错误';
        return false;
    }

    /**
     * 获取错误信息
     * @return string
     */
    public function getError()
    {
        $error = $this->error;
        $this->error = null;
        return $error;
    }
}
