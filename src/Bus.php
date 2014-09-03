<?php namespace StudioIgnis\Cmd;

interface Bus
{
    public function execute(Command $command);
}
