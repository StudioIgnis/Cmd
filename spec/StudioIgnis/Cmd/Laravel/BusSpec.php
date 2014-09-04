<?php

namespace spec\StudioIgnis\Cmd\Laravel;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Illuminate\Container\Container;
use StudioIgnis\Cmd\NameInflector;
use StudioIgnis\Cmd\Command;

class BusSpec extends ObjectBehavior
{
    function let(Container $container, NameInflector $inflector)
    {
        $this->beConstructedWith($container, $inflector);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('StudioIgnis\Cmd\Laravel\Bus');
        $this->shouldHaveType('StudioIgnis\Cmd\Bus');
    }

    function it_executes_a_command(Command $cmd, Container $container, NameInflector $inflector, FooHandler $handler)
    {
        $inflector->getHandler($cmd)
            ->willReturn('FooHandler')
            ->shouldBeCalled();

        $container->make('FooHandler')
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
