<?php

namespace Yuyue8\Tpcores\commands\make\services;

use Yuyue8\Tpcores\commands\make\Make;

class Model extends Make
{
    protected $type = "model";

    protected function configure()
    {
        $this->setName('make:model')
            ->setDescription('Create a new model class');
    }
}
