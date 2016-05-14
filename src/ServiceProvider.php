<?php

namespace IRWeb\Orchestrate;

use andrefelipe\Orchestrate\Application;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    protected $defer = true;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/orchestrate.php' => config_path('orchestrate.php'),
        ]);
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('andrefelipe\Orchestrate\Application', function ($app) {
            return new Application(
              config('orchestrate.key'),
              config('orchestrate.host'),
              config('orchestrate.version')
            );
        });
        $this->app->alias('orchestrate', 'andrefelipe\Orchestrate\Application');
    }

    public function provides()
    {
        return ['andrefelipe\Orchestrate\Application'];
    }
}
