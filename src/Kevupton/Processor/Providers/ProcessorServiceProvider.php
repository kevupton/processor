<?php namespace Kevupton\Processor\Providers;

use Illuminate\Support\ServiceProvider;

class ProcessorServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__.'/../../../config/Processor.php' => config_path('processor.php')]);
        $this->publishes([
            __DIR__.'/../../../database/migrations/' => database_path('migrations')
        ], 'migrations');
        $this->publishes([
            __DIR__.'/../../../database/seeds/' => database_path('seeds')
        ], 'seeds');

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
//
    }
}