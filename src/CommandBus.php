<?php namespace StudioIgnis\Cmd;

use Doctrine\Instantiator\Exception\UnexpectedValueException;
use StudioIgnis\Cmd\Support\Container;

class CommandBus implements Bus
{

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var NameInflector
     */
    protected $inflector;

    /**
     * @var array
     */
    public $handlers = [];

    public function __construct(Container $container, NameInflector $inflector)
    {
        $this->container = $container;
        $this->inflector = $inflector;
    }

    /**
     * Execute the given command
     *
     * @param Command $command
     * @return mixed Whatever the command returns
     */
    public function execute(Command $command)
    {
        return $this->getHandler($command)->handle($command);
    }

    /**
     * Explicitly set a handler for a command
     *
     * @param string $command
     * @param string $handler
     */
    public function setHandler($command, $handler)
    {
        $this->handlers[$command] = $handler;
    }

    private function getHandler(Command $command)
    {
        $handler = $this->resolveHandlerClass(get_class($command));

        if (is_string($handler)) {
            $handler = $this->container->resolve($handler);
        } elseif ($handler instanceof \Closure) {
            $handler = $handler();
        }

        if (!$handler instanceof Handler) {
            throw new UnexpectedValueException(
                sprintf("[%s] should be an instance of %s", get_class($handler), 'StudioIgnis\Cmd\Handler')
            );
        }

        return $handler;
    }

    private function resolveHandlerClass($commandClass)
    {
        return isset($this->handlers[$commandClass])
            ? $this->handlers[$commandClass]
            : $this->inflector->getHandler($commandClass);
    }
}
