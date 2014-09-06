<?php

namespace StudioIgnis\Cmd;

class NameInflector
{
    public function getHandler($commandName)
    {
        return str_replace('Command', 'Handler', $commandName);
    }
}
