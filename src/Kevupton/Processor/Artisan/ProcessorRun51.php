<?php

namespace Kevupton\Processor\Artisan;

use Illuminate\Console\Command;
use Kevupton\Processor\Processor;

class ProcessorRun51 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'processor:run';

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
    public function handle()
    {
        $processor= new Processor();
        $processor->run();
    }
}
