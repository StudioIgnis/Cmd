<?php namespace StudioIgnis\Cmd;

use Illuminate\Container\Container;

class LaravelBus implements Bus
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
