<?php

namespace spec\StudioIgnis\Cmd;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use StudioIgnis\Cmd\Command;

class CommandSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf('spec\StudioIgnis\Cmd\DummyCommand');
        $this->beConstructedWith('bar', 'qux');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('StudioIgnis\Cmd\Command');
        $this->shouldHaveType('JsonSerializable');
        $this->shouldHaveType('Illuminate\Support\Contracts\JsonableInterface');
        $this->shouldHaveType('Illuminate\Support\Contracts\ArrayableInterface');
    }

    function it_gets_overloaded_attributes()
    {
        $this->foo->shouldBe('bar');
        $this->baz->shouldBe('qux');
    }

    function it_can_be_converted_to_array()
    {
        $this->toArray()->shouldBeLike([
            'foo' => 'bar',
            'baz' => 'qux',
        ]);
    }

    function it_can_be_converted_to_json()
    {
        $this->toJson()->shouldBe('{"foo":"bar","baz":"qux"}');
    }

    function it_can_be_casted_to_json_string()
    {
        $this->__toString()->shouldBeLike('{"foo":"bar","baz":"qux"}');
    }

    function it_can_be_json_encoded()
    {
        json_encode($this);
    }
}

class DummyCommand extends Command
{
    public function __construct($foo, $baz)
    {
        $this->attributes = compact('foo', 'baz');
    }
}
