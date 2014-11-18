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
            $cmd = $this->cmd($commandName, $this->getInput($input));
        }

        return $this->getCommandBus()->execute($cmd);
    }

    protected function getInput(array $input = null)
    {
        return $input ?: Input::all();
    }

    protected function getCommandBus()
    {
        return App::make('StudioIgnis\Cmd\Bus');
    }
}
