<?php

namespace Yuyue8\Tpcores\commands\make\services;

use Yuyue8\Tpcores\commands\make\Make;

class Controller extends Make
{
    protected $type = "controller";

    protected function configure()
    {
        $this->setName('make:controller')
            ->setDescription('Create a new controller class');
    }
}
