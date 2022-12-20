<?php

namespace Yuyue8\Tpcores\commands\make\services;

use Yuyue8\Tpcores\commands\make\Make;

class Services extends Make
{
    protected $type = "services";

    protected function configure()
    {
        $this->setName('make:services')
            ->setDescription('Create a new services class');
    }
}
