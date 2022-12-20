<?php

namespace Yuyue8\Tpcores\commands\make\services;

use Yuyue8\Tpcores\commands\make\Make;

class Subscribe extends Make
{
    protected $type = "subscribe";

    protected function configure()
    {
        $this->setName('make:subscribe')
            ->setDescription('Create a new subscribe class');
    }
}
