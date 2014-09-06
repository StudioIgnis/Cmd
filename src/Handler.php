<?php namespace StudioIgnis\Cmd;

interface Handler
{
    public function handle(Command $command);
}
