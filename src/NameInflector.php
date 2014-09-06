<?php

namespace StudioIgnis\Cmd;

class NameInflector
{
    public function getHandler(Command $command)
    {
        return str_replace('Command', 'Handler', get_class($command)).'Handler';
    }
}
