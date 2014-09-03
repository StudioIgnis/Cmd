<?php

namespace spec\StudioIgnis\Cmd;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use StudioIgnis\Cmd\Command;

class NameInflectorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('StudioIgnis\Cmd\NameInflector');
    }

    function it_gets_handler_name(Command $command)
    {
        $this->getHandler($command)->shouldBe(
            get_class($command->getWrappedObject()).'Handler'
        );
    }
}
