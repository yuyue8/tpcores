<?php

namespace Yuyue8\Tpcores\commands\make\services;

use Yuyue8\Tpcores\commands\make\Make;

class Dao extends Make
{
    protected $type = "dao";

    protected function configure()
    {
        $this->setName('make:dao')
            ->setDescription('Create a new dao class');
    }
}
