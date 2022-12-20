<?php

namespace Yuyue8\Tpcores\commands\make\services;

use Yuyue8\Tpcores\commands\make\Make;

class Validate extends Make
{
    protected $type = "validate";

    protected function configure()
    {
        $this->setName('make:validate')
            ->setDescription('Create a new validate class');
    }
}
