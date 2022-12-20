# tpcores

## 安装
~~~
composer require yuyue8/tpcores
~~~

## 使用流程
1、.ENV文件中设置域名空间名称,默认不设置为`cores`
```
[TPCORES]
NAMESPACE = cores
```
2、使域名空间生效

2.1、项目根目录`composer.json`->`autoload`->`psr-4`内添加域名空间设置,内容为上一步设置的名称
```
"cores\\": "cores"
```

2.2、执行命令
~~~
composer install
~~~

3、创建类文件

3.1、下边命令将同时创建`Model`层、`Dao`层、`Cache`层、`Services`层类文件
```
php think make:cores index/admin
或者
php think make:cores index/admin m,d,c,s
或者
php think make:cores index/admin c,d,m,s
```
参数解释：
index/admin：所创建类域名空间层级，也可没有层级，如：admin。创建时默认转为大驼峰
c,d,m,s：所创建的多个类别，也可只创建一个类别，如：c

3.2、支持类型

`Cache`：缓存层，参数：cache|c

`Controller`：控制器层，参数：controller|C

`Dao`：dao层，参数：dao|d|D

`Exception`：异常处理，参数：exception|e|E

`Jobs`：消息队列，参数：jobs|j|J

`Listener`：事件监听，参数：listener|l|L

`Middleware`：中间件，参数：middleware|M

`Model`：model层，参数：model|m

`Services`：Services层，参数：services|s

`Subscribe`：事件订阅，参数：subscribe|S

`Validate`：验证器，参数：validate|v|V

4、类介绍

调用逻辑：
`Controller`控制器层-》`Services`层-》`Cache`缓存层-》`Dao`层-》`Model`层

介绍：
`Services`层可以直接调用`Cache`缓存层获取数据，若在缓存层查询不到，自动去`Dao`层查找。
`Model`层写入数据和删除数据时，自动调用模型事件，调用`Cache`缓存层自动删除设置的缓存

`Exception`：
修改`app`-》`provider`文件下的`'think\exception\Handle'`为`basic`-》`BaseException`类

`Jobs`：
消息队列执行逻辑已内置，只需写队列任务逻辑即可
提供`dispatch`加入队列、`dispatchSece`延迟加入队列、`dispatchDo`加入小队列三个快捷入队列方法

使用前需要安装`topthink/think-queue`插件
~~~
composer require topthink/think-queue
~~~

使用方法如下：
```php
/** @var Job $job */
$job = app(Job::class);
$job->dispatch(['参数1','参数2'...]);
$job->dispatchSece('延迟时间',['参数1','参数2'...]);
$job->dispatchDo('执行方法名',['参数1','参数2'...],'延长时间');
```

`Validate`：

验证失败时直接抛出异常，无需额外判断，返回值为所有验证参数的数组，无验证的参数直接过滤
内置验证方法`Yuyue8\Tpcores\basic\BaseValidate`可查看

使用如下：
```php
/** @var Validate $validate */
$validate = app(Validate::class);
$validate -> scene('save') -> goCheck();
```

如需不抛出异常，使用如下：
```php
/** @var Validate $validate */
$validate = app(Validate::class);
$validate -> scene('save') -> goCheck2();
```