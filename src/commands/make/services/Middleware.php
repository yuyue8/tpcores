<?php

namespace Yuyue8\Tpcores\commands\make\services;

use Yuyue8\Tpcores\commands\make\Make;

class Middleware extends Make
{
    protected $type = "middleware";

    protected function configure()
    {
        $this->setName('make:middleware')
            ->setDescription('Create a new middleware class');
    }
}
