<?php

namespace Yuyue8\Tpcores\commands\make\services;

use Yuyue8\Tpcores\commands\make\Make;

class Cache extends Make
{
    protected $type = "cache";

    protected function configure()
    {
        $this->setName('make:cache')
            ->setDescription('Create a new cache class');
    }
}
