<?php

namespace spec\StudioIgnis\Cmd;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use StudioIgnis\Cmd\Command;
use StudioIgnis\Cmd\Handler;
use StudioIgnis\Cmd\NameInflector;
use StudioIgnis\Cmd\Support\Container;

class CommandBusSpec extends ObjectBehavior
{
    function let(Container $container, NameInflector $inflector)
    {
        $this->beConstructedWith($container, $inflector);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('StudioIgnis\Cmd\Bus');
        $this->shouldHaveType('StudioIgnis\Cmd\CommandBus');
    }

    function it_executes_a_command(Command $cmd, Container $container, NameInflector $inflector, FooHandler $handler)
    {
        $inflector->getHandler(get_class($cmd->getWrappedObject()))
            ->willReturn('FooHandler')
            ->shouldBeCalled();

        $container->resolve('FooHandler')
            ->willReturn($handler)
            ->shouldBeCalled();

        $handler->handle($cmd)->shouldBeCalled();

        $this->execute($cmd);
    }

    function it_explicitly_sets_a_command_handler(Command $cmd, Container $container, FooHandler $handler)
    {
        $handlerClass = 'SomeHandler';

        $this->setHandler(get_class($cmd->getWrappedObject()), $handlerClass);

        $container->resolve($handlerClass)
            ->willReturn($handler)
            ->shouldBeCalled();

        $handler->handle($cmd)->shouldBeCalled();

        $this->execute($cmd);
    }

    function it_resolves_a_handler_from_a_closure(Command $cmd, FooHandler $handler)
    {
        $handlerClass = 'SomeHandler';

        $this->setHandler(get_class($cmd->getWrappedObject()), function() use($handler) {
            return $handler->getWrappedObject(); // Get double
        });

        $handler->handle($cmd)->shouldBeCalled();

        $this->execute($cmd);
    }
}

class FooHandler implements Handler
{
    public function handle(Command $cmd) {}
}
