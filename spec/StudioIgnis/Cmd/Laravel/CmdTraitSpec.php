<?php

namespace spec\StudioIgnis\Cmd\Laravel;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CmdTraitSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf('spec\StudioIgnis\Cmd\Laravel\DummyController');
    }

    function it_gets_a_command_instance()
    {
        $cmd = $this->cmd(DummyCommand::class, ['foo' => 'bar'])
            ->shouldBeAnInstanceOf(DummyCommand::class);
    }

    function it_fails_to_map_wrong_input()
    {
        $this->shouldThrow('\InvalidArgumentException')
            ->duringCmd(DummyCommand::class, []);
    }
}

class DummyCommand extends \StudioIgnis\Cmd\Command
{
    public function __construct($foo, $baz = 'qux')
    {
        $this->attributes = compact('foo', 'baz');
    }
}

class DummyController
{
    use \StudioIgnis\Cmd\Laravel\CmdTrait;
}
