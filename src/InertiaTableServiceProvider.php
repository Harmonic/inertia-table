<?php

namespace harmonic\InertiaTable;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

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
        // Easily create all the inertia routes
        Route::macro('inertiaTable', function ($routeName, $controller = null, $routeKey = null) {
            $routeName = strtolower($routeName);
            $routeKey = $routeKey ? $routeKey : Str::singular($routeName);
            $routePlaceholder = sprintf('{%s}', $routeKey);
            $controller = $controller ? $controller : ucfirst($routeName).'Controller';


            Route::group([
                'prefix' => '/'.$routeName,
            ], function () use ($controller, $routeName, $routePlaceholder) {
                Route::get('/')->name($routeName)->uses($controller.'@index')->middleware('remember');
                Route::get('/create')->name($routeName.'.create')->uses($controller.'@create');
                Route::post('/')->name($routeName.'.store')->uses($controller.'@store');
                Route::get(sprintf('/%s/edit', $routePlaceholder))->name($routeName.'.edit')->uses($controller.'@edit');
                Route::put(sprintf('/%s', $routePlaceholder))->name($routeName.'.update')->uses($controller.'@update');
                Route::delete(sprintf('/%s', $routePlaceholder))->name($routeName.'.destroy')->uses($controller.'@destroy');
                Route::put(sprintf('/%s/restore', $routePlaceholder))->name($routeName.'.restore')->uses($controller.'@restore');
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
    }
}
