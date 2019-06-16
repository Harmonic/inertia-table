<?php

namespace harmonic\InertiaTable;

use Illuminate\Support\ServiceProvider;

class InertiaTableServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'harmonic');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'harmonic');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/inertiatable.php', 'inertiatable');

        // Register the service the package provides.
        $this->app->singleton('inertiatable', function ($app) {
            return new InertiaTable;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['inertiatable'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/inertiatable.php' => config_path('inertiatable.php'),
        ], 'inertiatable.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/harmonic'),
        ], 'inertiatable.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/harmonic'),
        ], 'inertiatable.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/harmonic'),
        ], 'inertiatable.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
