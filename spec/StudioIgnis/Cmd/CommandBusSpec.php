<?php

namespace spec\StudioIgnis\Cmd;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use StudioIgnis\Cmd\Command;
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
}

class FooHandler
{
    public function handle($cmd) {}
}
