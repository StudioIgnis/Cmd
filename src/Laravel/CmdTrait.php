<?php namespace StudioIgnis\Cmd\Laravel;

use Input, App;

trait CmdTrait
{
    use \StudioIgnis\Cmd\CmdTrait;

    public function execute($commandName, array $input = null)
    {
        $this->getCommandBus()->execute(
            $this->cmd($commandName, $input ?: Input::all())
        );
    }

    protected function getCommandBus()
    {
        return App::make('StudioIgnis\Cmd\Bus');
    }
}
