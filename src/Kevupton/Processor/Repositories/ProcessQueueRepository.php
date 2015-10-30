<?php namespace Kevupton\Processor\Repositories;

use Kevupton\BeastCore\Repositories\BeastRepository;
use Kevupton\Processor\Exceptions\ProcessQueueException;
use Kevupton\Processor\Models\ProcessQueue;
use Kevupton\Processor\Package;

class ProcessQueueRepository extends BeastRepository {

    protected $exceptions = [
        'main' => ProcessQueueException::class,
    ];

    /**
     * Retrieves the class instance of the specified repository.
     *
     * @return string the string instance of the defining class
     */
    function getClass()
    {
        return ProcessQueue::class;
    }


    /**
     * Gets the ready processes to be run in order of execution.
     */
    public function getReadyProcesses() {
        $list = ProcessQueue::where('exec_datetime', '<=', current_datetime())
            ->orderBy('exec_datetime', 'asc')
            ->get();

        return $list;
    }


    /**
     * Registers a package in the process queue.
     *
     * @param Package $package
     * @param int $runtime
     * @param null $category
     */
    public function registerPackage(Package $package, $runtime = 0, $category = null) {
        $process = ProcessQueue::create([
            'package' => get_class($package),
            'data' => serialize($package),
            'category' => $category,
            'exec_datetime' => is_string($runtime)? add_time($runtime): add_time("$runtime minutes")
        ]);

        //if there are errors let us know
        $this->throwErrors($process);
    }

    /**
     * Removes the process queue from the list
     *
     * @param ProcessQueue $queue
     * @throws \Exception
     */
    public function remove(ProcessQueue $queue) {
        $queue->delete();
    }
}