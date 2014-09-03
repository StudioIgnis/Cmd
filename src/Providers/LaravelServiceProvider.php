<?php namespace StudioIgnis\Cmd\Providers;

use Illuminate\Support\ServiceProvider;

class LaravelServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bindShared('StudioIgnis\Cmd\BusInterface', function($app)
        {
            return $app->make('StudioIgnis\Cmd\LaravelBus');
        });
    }
}
