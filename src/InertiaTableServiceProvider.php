<?php

namespace harmonic\InertiaTable;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class InertiaTableServiceProvider extends ServiceProvider
{
    protected $commands = [
        'harmonic\InertiaTable\Commands\MakeInertiaTable',
    ];
    
    
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

        // Easily create all the inertia routes
        Route::macro('inertia', function ($routeName) {
            $routeName = strtolower($routeName);
            $controller = ucfirst($routeName) . 'Controller';
            
            Route::group([
                'prefix' => '/' . $routeName,
            ], function () use ($controller, $routeName) {
                Route::get('/')->name($routeName)->uses($controller . '@index')->middleware('remember');
                Route::get('/create')->name($routeName . '.create')->uses($controller . '@create');
                Route::post('')->name($routeName . '.store')->uses($controller . '@store');
                Route::get('/{user}/edit')->name($routeName . '.edit')->uses($controller . '@edit');
                Route::put('/{user}')->name($routeName . '.update')->uses($controller . '@update');
                Route::delete('/{user}')->name($routeName . '.destroy')->uses($controller . '@destroy');
                Route::put('/{user}/restore')->name($routeName . '.restore')->uses($controller . '@restore');
            });
        });

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

        $this->commands($this->commands);

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
