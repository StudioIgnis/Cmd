<?php

namespace spec\StudioIgnis\Cmd;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NameInflectorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('StudioIgnis\Cmd\NameInflector');
    }

    function it_gets_handler_name()
    {
        $this->getHandler('Foo\Command\DoStuff')->shouldBe(
            'Foo\Handler\DoStuff'
        );

        $this->getHandler('Foo\Command\DoStuffCommand')->shouldBe(
            'Foo\Handler\DoStuffHandler'
        );

        $this->getHandler('Foo\Commands\DoStuffCommand')->shouldBe(
            'Foo\Handlers\DoStuffHandler'
        );
    }
}
