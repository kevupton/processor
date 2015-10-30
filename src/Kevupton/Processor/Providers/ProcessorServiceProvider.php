<?php namespace Kevupton\Processor\Providers;

use Illuminate\Support\ServiceProvider;
use Kevupton\Processor\Artisan\ProcessorRun42;
use Kevupton\Processor\Artisan\ProcessorRun51;

class ProcessorServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $laravel = app();

        if ($laravel::VERSION < 5) {
            $this->commands(ProcessorRun42::class);
        }  else {
            $this->commands(ProcessorRun51::class);

            $this->publishes([__DIR__.'/../../../config/Processor.php' => config_path('processor.php')]);
            $this->publishes([
                __DIR__.'/../../../database/migrations/' => database_path('migrations')
            ], 'migrations');
            $this->publishes([
                __DIR__.'/../../../database/seeds/' => database_path('seeds')
            ], 'seeds');
        }
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