<?php

namespace Yuyue8\Tpcores;

use Yuyue8\Tpcores\commands\Make;

class Service extends \think\Service
{

    public function boot()
    {
        $this->commands(
            Make::class
        );
    }

}
