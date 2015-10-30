<?php namespace Kevupton\Processor\Artisan;

use Illuminate\Console\Command;
use Kevupton\Processor\Processor;

class ProcessorRun42 extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'processor:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs the processor.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $processor= new Processor();
        $processor->run();
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array();
    }

}
