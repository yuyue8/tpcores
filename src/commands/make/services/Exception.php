<?php

namespace Yuyue8\Tpcores\commands\make\services;

use Yuyue8\Tpcores\commands\make\Make;

class Exception extends Make
{
    protected $type = "exception";

    protected function configure()
    {
        $this->setName('make:exception')
            ->setDescription('Create a new exception class');
    }
}
