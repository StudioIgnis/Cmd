<?php namespace StudioIgnis\Cmd;

use JsonSerializable;
use Illuminate\Support\Contracts\JsonableInterface;
use Illuminate\Support\Contracts\ArrayableInterface;

abstract class Command implements JsonSerializable, JsonableInterface, ArrayableInterface
{
    protected $attributes = [];

    public function __get($name)
    {
        return $this->attributes[$name];
    }

    public function __toString()
    {
        return $this->toJson();
    }

    function jsonSerialize()
    {
        return $this->attributes;
    }

    public function toArray()
    {
        return $this->attributes;
    }

    public function toJson($options = 0)
    {
        return json_encode($this, $options);
    }
}
