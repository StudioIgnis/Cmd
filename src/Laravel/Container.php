<?php namespace StudioIgnis\Cmd\Laravel;

use StudioIgnis\Cmd\Support\Container as ContainerInterface;
use Illuminate\Container\Container as IlluminateContainer;

class Container implements ContainerInterface
{
    /**
     * @var IlluminateContainer
     */
    private $app;

    public function __construct(IlluminateContainer $app)
    {
        $this->app = $app;
    }

    /**
     * Resolve a class by it's alias in an app container
     *
     * @param $abstract
     * @return mixed
     */
    public function resolve($abstract)
    {
        return $this->app->make($abstract);
    }
}
