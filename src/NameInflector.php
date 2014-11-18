<?php namespace StudioIgnis\Cmd;

interface NameInflector
{
    public function getHandler($commandName);
}
