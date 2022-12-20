<?php

namespace Yuyue8\Tpcores\commands\make;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\Output;
use think\facade\Env;
use think\helper\Str;

abstract class Make extends Command
{
    protected $type;

    protected function getStub(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . $this->type . '.stub';
    }

    protected function configure()
    {
        $this->addArgument('name', Argument::REQUIRED, "The name of the class");
    }

    protected function execute(Input $input, Output $output)
    {
        $name = trim($input->getArgument('name'));

        $classname = $this->getClassName($name);

        $pathname = $this->getPathName($classname);

        if (is_file($pathname)) {
            $output->writeln('<error>' . $this->type . ':' . $classname . ' already exists!</error>');
            return false;
        }

        $this->createBase($output);

        if (!is_dir(dirname($pathname))) {
            mkdir(dirname($pathname), 0755, true);
        }

        file_put_contents($pathname, $this->buildClass($classname,$name));

        $output->writeln('<info>' . $this->type . ':' . $classname . ' created successfully.</info>');
    }

    protected function buildClass(string $name)
    {
        $stub = file_get_contents($this->getStub());

        $namespace = trim(implode('\\', array_slice(explode('\\', $name), 0, -1)), '\\');

        $class = str_replace($namespace . '\\', '', $name);

        return str_replace(['{%className%}', '{%classNameSnake%}', '{%namespace%}', '{%namespaceSuffix%}', '{%namespacePrefix%}'], [
            $class,
            Str::snake($class),
            $namespace,
            str_replace($this->getNamespace() . '\\' . $this->type . '\\', '', $name),
            $this->getNamespace(true)
        ], $stub);
    }

    protected function getPathName(string $name): string
    {
        return $this->app->getRootPath() . ltrim(str_replace('\\', '/', $name), '/') . ($this->type != 'controller' ? Str::studly($this->type) : '') . '.php';
    }

    protected function getClassName(string $name): string
    {
        if (strpos($name, '/') !== false) {
            $name = str_replace('/', '\\', $name);
        }

        $name_array = explode('\\',$name);
        $key = count($name_array)-1;
        $name_array[$key] = Str::studly($name_array[$key]);
        $name = implode('\\',$name_array);

        return $this->getNamespace() . '\\' . $this->type . '\\' . $name;
    }

    protected function getNamespace(bool $is_cores = false): string
    {
        return ($this->type != 'controller' || $is_cores) ? Env::get('tpcores.namespace','cores') : 'app';
    }

    public function createBase(Output $output)
    {
        if(!in_array($this->type,['cache','dao','exception','jobs','model','services','validate','controller'])){
            return true;
        }

        $name = 'Base' . Str::studly($this->type);

        $classname = $this->getNamespace(true) . '\\basic\\' . $name;

        $pathname = $this->app->getRootPath() . ltrim(str_replace('\\', '/', $classname), '/') . '.php';

        if (is_file($pathname)) {
            return true;
        }

        if (!is_dir(dirname($pathname))) {
            mkdir(dirname($pathname), 0755, true);
        }

        $stub = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'base.stub');

        $namespace = trim(implode('\\', array_slice(explode('\\', $classname), 0, -1)), '\\');

        $class = str_replace($namespace . '\\', '', $classname);

        file_put_contents($pathname, str_replace(['{%className%}', '{%namespace%}'], [
            $class,
            $namespace
        ], $stub));

        $output->writeln('<info>' . $name . ' created successfully.</info>');
    }

}
