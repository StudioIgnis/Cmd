<?php namespace StudioIgnis\Cmd;

interface Bus
{
    /**
     * Execute the given command
     *
     * @param Command $command
     * @return mixed Whatever the command returns
     */
    public function execute(Command $command);

    /**
     * Explicitly set a handler for a command
     *
     * @param string $command
     * @param string $handler
     */
    public function setHandler($command, $handler);
}
