<?php namespace StudioIgnis\Cmd\Laravel;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->app->bindShared('StudioIgnis\Cmd\Bus', function($app)
        {
            return $app->make('StudioIgnis\Cmd\Laravel\Bus');
        });
    }
}
