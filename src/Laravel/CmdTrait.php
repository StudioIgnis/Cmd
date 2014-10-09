<?php namespace StudioIgnis\Cmd\Laravel;

use Input, App;
use StudioIgnis\Cmd\Command;

trait CmdTrait
{
    use \StudioIgnis\Cmd\CmdTrait;

    public function execute($commandName, array $input = null)
    {
        if ($commandName instanceof Command) {
            $cmd = $commandName;
        } else {
            $cmd = $this->cmd($commandName, $input ?: Input::all());
        }

        return $this->getCommandBus()->execute($cmd);
    }

    protected function getCommandBus()
    {
        return App::make('StudioIgnis\Cmd\Bus');
    }
}
