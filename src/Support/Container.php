<?php namespace StudioIgnis\Cmd\Support;

interface Container
{
    /**
     * Resolve a class by it's alias in an app container
     *
     * @param $abstract
     * @return mixed
     */
    public function resolve($abstract);
}
