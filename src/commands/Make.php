<?php

namespace Yuyue8\Tpcores\commands;

use think\console\Command;
use think\console\input\Argument;

class Make extends Command
{

    public $types = [
        'controller' => 'Controller',
        'C'          => 'Controller',
        'cache'      => 'Cache',
        'c'          => 'Cache',
        'dao'        => 'Dao',
        'd'          => 'Dao',
        'D'          => 'Dao',
        'exception'  => 'Exception',
        'e'          => 'Exception',
        'E'          => 'Exception',
        'jobs'       => 'Jobs',
        'j'          => 'Jobs',
        'J'          => 'Jobs',
        'listener'   => 'Listener',
        'l'          => 'Listener',
        'L'          => 'Listener',
        'middleware' => 'Middleware',
        'M'          => 'Middleware',
        'model'      => 'Model',
        'm'          => 'Model',
        'services'   => 'Services',
        's'          => 'Services',
        'subscribe'  => 'Subscribe',
        'S'          => 'Subscribe',
        'validate'   => 'Validate',
        'v'          => 'Validate',
        'V'          => 'Validate',
    ];

    public function configure()
    {
        parent::configure();
        $this->setName('make:cores')
        ->addArgument('name', Argument::REQUIRED, "The name of the class")
        ->addArgument('type', Argument::OPTIONAL, "The type of the class", 'c,d,m,s');
    }

    public function handle()
    {

        $types = explode(',', trim($this->input->getArgument('type')));

        if(!$this->typeValidate($types)){
            return false;
        }

        foreach ($types as $value) {
            $make_type = '\\Yuyue8\\Tpcores\\commands\\make\\services\\'. $this->types[$value];
            $make = new $make_type();
            $make->setApp($this->app);
            $make->execute($this->input,$this->output);
        }
    }

    /**
     * 验证类型是否正确
     *
     * @param array $types
     * @return bool
     */
    public function typeValidate(array $types)
    {
        foreach ($types as $value) {
            if(!isset($this->types[$value])){
                $this->output->writeln('<error> 类型：' . $value . ' no exists!</error>');
                return false;
            }
        }
        return true;
    }
}
