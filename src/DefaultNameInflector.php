<?php namespace StudioIgnis\Cmd; 

class DefaultNameInflector implements NameInflector
{
    public function getHandler($commandName)
    {
        return str_replace('Command', 'Handler', $commandName);
    }
}
