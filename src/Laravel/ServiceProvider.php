<?php namespace StudioIgnis\Cmd\Laravel;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use StudioIgnis\Cmd\DefaultNameInflector;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->app->bindShared('StudioIgnis\Cmd\Support\Container', function ($app)
        {
            return new Container($app);
        });

        $this->app->bindShared('StudioIgnis\Cmd\NameInflector', function()
        {
            return new DefaultNameInflector;
        });

        $this->app->bindShared('StudioIgnis\Cmd\Bus', function($app)
        {
            return $app->make('StudioIgnis\Cmd\CommandBus');
        });
    }
}
