<?php
namespace Yuyue8\Tpcores\basic;

use think\exception\ValidateException;
use think\Validate;

/**
 * Class BaseValidate
 * 验证类的基类
 */
class BaseValidate extends Validate
{
    /**
     * 检测所有客户端发来的参数是否符合验证类规则
     * 基类定义了很多自定义验证方法
     * 这些自定义验证方法其实，也可以直接调用
     * @throws ParameterException
     * @return array
     */
    public function goCheck() {
        $params = request()->param();
        if (!$this->check($params)) {
            throw new ValidateException($this->error);
        }
        return $this-> getDataByRule($params);
    }

    public function goCheck2($params) {
        if (!$this->check($params)) {
            return false;
        }
        return true;
    }

    /**
     * @param array $arrays 通常传入request.post变量数组
     * @return array 按照规则key过滤后的变量数组
     * @throws ParameterException
     */
    public function getDataByRule($arrays) {
        return array_intersect_key($arrays,array_flip($this->only));
    }

    protected function isPositiveInteger($value) {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        }
        return false;
    }

    protected function isInteger($value) {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) >= 0) {
            return true;
        }
        return false;
    }

    protected function isNotEmpty($value) {
        if (empty($value)) {
            return false;
        } else {
            return true;
        }
    }

    //没有使用TP的正则验证，集中在一处方便以后修改
    //不推荐使用正则，因为复用性太差
    //手机号的验证规则
    protected function isMobile($value) {
        $rule = '^1(3|4|5|6|7|8|9)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    //验证多个正整数数组
    protected function isIntegers($ids){
        foreach ($ids as $value) {
            if (!is_numeric($value) || !is_int($value + 0) || ($value + 0) < 0) {
                return false;
            }
        }
        return true;
    }

    //验证时间段
    protected function times_str($val){
        $array = explode(' - ', $val);
        if(count($array) != 2){
            return false;
        }
        foreach ($array as $value) {
            if(date('Y-m-d',strtotime($value)) != $value){
                return false;
            }
        }
        return true;
    }

    /**
     *  [0,10,1],
     *  [10,20,2]
     *  合适验证
     * @return [type] [description]
     */
    protected function arrays($data){
        foreach ($data as $key => $value) {
            if(count($value) != 3){
                return false;
            }
            if(!$this->isIntegers($value)){
                return false;
            }
            if($key == 0){
                if($value[1] <= $value[0]){
                    return false;
                }
            }else{
                if($value[0] != $data[$key-1][1] || $value[1] <= $value[0] || $value[2] < $data[$key-1][2]){
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * 递增数字
     * [1,20,60,80]
     * @param array $data
     * @return bool
     */
    protected function incNumber(array $data)
    {
        foreach ($data as $key => $value) {
            if(!$this->isInteger($value)){
                return false;
            }
            if($key != 0 && $value <= $data[$key-1]){
                return false;
            }
        }
        return true;
    }

}