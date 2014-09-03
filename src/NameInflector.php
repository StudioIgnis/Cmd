<?php

namespace StudioIgnis\Cmd;

class NameInflector
{
    public function getHandler(Command $command)
    {
        return get_class($command).'Handler';
    }
}
