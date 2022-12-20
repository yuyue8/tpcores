<?php

namespace Yuyue8\Tpcores\commands\make\services;

use Yuyue8\Tpcores\commands\make\Make;

class Listener extends Make
{
    protected $type = "listener";

    protected function configure()
    {
        $this->setName('make:listener')
            ->setDescription('Create a new listener class');
    }
}
