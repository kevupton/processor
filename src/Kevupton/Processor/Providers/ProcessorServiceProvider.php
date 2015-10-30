<?php namespace Kevupton\Processor\Providers;

use Illuminate\Support\ServiceProvider;
use Kevupton\Processor\Artisan\ProcessorRun42;
use Kevupton\Processor\Artisan\ProcessorRun51;
use \Artisan;

class ProcessorServiceProvider extends ServiceProvider {

    protected $commands = [
        ProcessorRun51::class
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $laravel = app();

        if ($laravel::VERSION < 5) {
            Artisan::add(new ProcessorRun42());
            $this->commands('processor.run');
        }  else {
            $this->commands($this->commands);
        }

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