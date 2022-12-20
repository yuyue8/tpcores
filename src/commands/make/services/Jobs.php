<?php

namespace Yuyue8\Tpcores\commands\make\services;

use Yuyue8\Tpcores\commands\make\Make;

class Jobs extends Make
{
    protected $type = "jobs";

    protected function configure()
    {
        $this->setName('make:jobs')
            ->setDescription('Create a new jobs class');
    }
}
