<?php namespace StudioIgnis\Cmd;

abstract class Command
{
    protected $attributes = [];

    public function __get($name)
    {
        return $this->attributes[$name];
    }

    public function toArray()
    {
        return $this->attributes;
    }
}
