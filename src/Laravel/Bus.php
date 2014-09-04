<?php namespace StudioIgnis\Cmd\Laravel;

use StudioIgnis\Cmd\Bus as BusInterface;
use StudioIgnis\Cmd\Command;
use StudioIgnis\Cmd\NameInflector;
use Illuminate\Container\Container;

class Bus implements BusInterface
{
    protected $app;
    protected $inflector;

    public function __construct(Container $container, NameInflector $inflector)
    {
        $this->app = $container;
        $this->inflector = $inflector;
    }

    public function execute(Command $command)
    {
        return $this->getHandler($command)->handle($command);
    }

    protected function getHandler(Command $command)
    {
        return $this->app->make($this->inflector->getHandler($command));
    }
}
