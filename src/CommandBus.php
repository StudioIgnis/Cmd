<?php namespace StudioIgnis\Cmd;

use StudioIgnis\Cmd\Support\Container;

class CommandBus implements Bus
{
    protected $container;
    protected $inflector;

    public function __construct(Container $container, NameInflector $inflector)
    {
        $this->container = $container;
        $this->inflector = $inflector;
    }

    public function execute(Command $command)
    {
        return $this->getHandler($command)->handle($command);
    }

    protected function getHandler(Command $command)
    {
        return $this->container->resolve($this->inflector->getHandler(get_class($command)));
    }
}
