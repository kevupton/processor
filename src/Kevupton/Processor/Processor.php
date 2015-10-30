<?php

use Kevupton\Processor\Package;
use Kevupton\Processor\Process;
use Kevupton\Referrals\Repositories\ProcessQueueRepository;

class Processor {

    private $processes = array();

    /**
     * @var ProcessQueueRepository
     */
    private $repo;

    /**
     * Loads the instance and initiates the process_model.
     */
    public function __construct() {
        $this->registerProcesses();
        $this->repo = new ProcessQueueRepository();
    }

    /**
     * Gets current processes queued up to run.
     */
    private function registerProcesses() {
        $processes = $this->repo->getReadyProcesses();
        foreach ($processes as $p) {
            $this->processes[] = new Process($p);
        }
    }

    /**
     * Runs the processor executing all of the giving processes.
     */
    public function run() {
        foreach ($this->processes as $process) {
            $process->execute();
        }
    }

    /**
     * Registers a new process in the system with the given data
     *
     * @param Package $package
     * @param string|int $runtime the string of the run datetime, or the number of minutes in which to run the process after the current datetime
     * @param null|string $category the category that it belongs to
     */
    public static function register(Package $package, $runtime = 0, $category = null) {
        $repo = new ProcessQueueRepository();
        $repo->registerPackage($package, $runtime, $category);
    }
}