<?php

namespace IRWeb\Orchestrate;

use Cache;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Kevinrob\GuzzleCache\Storage\LaravelCacheStorage;
use Kevinrob\GuzzleCache\Strategy\GreedyCacheStrategy;

use andrefelipe\Orchestrate;
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
            $httpClient = $this->createHttpClient();

            $application = new Orchestrate\Application();
            $application->setHttpClient($httpClient);

            if($cacheDriver = config('orchestrate.cache_driver')) {

            }
            return $application;
        });

        $this->app->singleton('andrefelipe\Orchestrate\Client', function ($app) {
            $httpClient = $this->createHttpClient();

            $application = new Orchestrate\Client();
            $application->setHttpClient($httpClient);

            return $application;
        });
    }

    public function provides()
    {
        return [
            'andrefelipe\Orchestrate\Client',
            'andrefelipe\Orchestrate\Application',
        ];
    }

    private function createHttpClient()
    {
        // Use andrefelipe helper function to get the base config array
        $config = Orchestrate\default_http_config(
            config('orchestrate.key'),
            config('orchestrate.host'),
            config('orchestrate.version')
        );

        if( $cacheDriver = config('orchestrate.cache_driver') ) 
        {
            $config['stack'] = $this->createCacheStack($cacheDriver);
        }

        return new \GuzzleHttp\Client($config);
    }

    private function createCacheStack($driver) 
    {
      // Create default HandlerStack
      $stack = \GuzzleHttp\HandlerStack::create();

      $stack->push(
          new CacheMiddleware(
              new GreedyCacheStrategy(
                  new LaravelCacheStorage(
                      Cache::store($driver)
                  )
              , 24 * 60 * 60) // 24 hours
          ),
          'cache'
      );

      return $stack;
    }
}
