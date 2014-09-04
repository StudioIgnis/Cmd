<?php namespace StudioIgnis\Cmd\Laravel;

use Illuminate\Support\ServiceProvider;

class ServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bindShared('StudioIgnis\Cmd\BusInterface', function($app)
        {
            return $app->make('StudioIgnis\Cmd\LaravelBus');
        });
    }
}
