<?php
namespace Yuyue8\Tpcores\basic;

use think\db\exception\DbException;
use think\exception\Handle;
use think\exception\ValidateException;
use think\facade\Env;
use think\facade\Log;
use think\Response;
use Throwable;

class BaseException extends Handle
{
    /**
     * 不需要记录信息（日志）的异常类列表
     * @var array
     */
    protected $ignoreReport = [
        ValidateException::class,
    ];

    /**
     * 记录异常信息（包括日志或者其它方式记录）
     * @access public
     * @param Throwable $exception
     * @return void
     */
    public function report(Throwable $exception): void
    {
        if (!$this->isIgnoreReport($exception)) {
            $data = [
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'message' => $this->getMessage($exception),
                'code' => $this->getCode($exception),
            ];

            //日志内容
            $log = [
                request()->has('loginId') ? request()->param('loginId') : null,                                    //管理员ID
                request()->ip(),                                                                      //客户ip
                request()->method(),                                                       //请求类型
                str_replace("/", "", request()->rootUrl()),                                           //应用
                request()->baseUrl(),                                                                 //路由
                json_encode(request()->param(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),     //请求参数
                json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),                  //报错数据
            ];
            Log::write(implode("|", $log), "error");
        }
    }

    /**
     * Render an exception into an HTTP response.
     * @access public
     * @param \think\Request $request
     * @param Throwable $e
     * @return Response
     */
    public function render($request, Throwable $e): Response
    {
        $massageData = Env::get('app_debug', false) ? [
            'file'     => $e->getFile(),
            'line'     => $e->getLine(),
            'trace'    => $e->getTrace(),
            'previous' => $e->getPrevious(),
        ] : [];
        // 添加自定义异常处理机制
        if ($e instanceof DbException) {
            $massageData += ['error'=>'失败','code'=>$e->getCode() ? : 400];
            return json($massageData);
        } elseif ($e instanceof ValidateException) {
            return json(['error'=>$e->getMessage(),'code'=>$e->getCode() ? : 400]);
        } else {
            $massageData += ['error'=>$e->getMessage(),'code'=>$e->getCode() ? : 400];
            return json($massageData);
        }
    }

}
