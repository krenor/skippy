<?php

namespace Skippy\Providers;

use Skippy\Exceptions\MissingConfigurationException;
use Illuminate\Support\ServiceProvider;
use Skippy\Skippy;

class SkippyServiceProvider extends ServiceProvider
{
    /**
     * Perform post registration operations.
     *
     * @return void
     */
    public function boot()
    {
        $config = __DIR__ . '/../config/skippy.php';

        // Add publishable configuration
        $this->publishes([
            $config => base_path('config/skippy.php'),
        ], 'config');
    }

    /**
     * Register the service provider.
     *
     * @throws \Skippy\Exceptions\MissingConfigurationException
     * @return void
     */
    public function register()
    {
        $this->app->singleton('skippy', function ($app) {
            if ($app['config']['skippy'] === null) {
                throw new MissingConfigurationException;
            }

            return new Skippy($app['config']['skippy']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['skippy'];
    }
}
