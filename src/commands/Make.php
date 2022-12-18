<?php

namespace Yuyue8\Tpcores\commands;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\Output;
use think\console\input\Option;
use Yuyue8\Tpcores\commands\make\Model;

class Make extends Command
{

    public function configure()
    {
        parent::configure();
        $this->setName('make:mdcs')->addArgument('name', Argument::REQUIRED, "The name of the class");
    }

    public function handle(Input $input,Output $output)
    {
        $model = new Model();
        $model->execute($input,$output);
    }
}
