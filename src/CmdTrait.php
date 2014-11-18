<?php namespace StudioIgnis\Cmd;

use Input, App;

trait CmdTrait
{
    public function cmd($commandName, array $input)
    {
        $params = [];

        $class = new \ReflectionClass($commandName);

        foreach($class->getConstructor()->getParameters() as $param)
        {
            $name = $param->getName();

            if (array_key_exists($name, $input))
            {
                $params[] = $input[$name];
            }
            elseif($param->isDefaultValueAvailable())
            {
                $params[] = $param->getDefaultValue();
            }
            else
            {
                throw new \InvalidArgumentException("Couldn't find [$name] in input for command [$commandName]");
            }
        }

        return $class->newInstanceArgs($params);
    }
}
