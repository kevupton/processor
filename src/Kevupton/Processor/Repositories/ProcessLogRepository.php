<?php namespace Kevupton\Referrals\Repositories;

use Kevupton\BeastCore\Repositories\BeastRepository;
use Kevupton\Processor\Exceptions\ProcessLogException;
use Kevupton\Processor\Models\ProcessLog;
use Kevupton\Processor\Models\ProcessQueue;


class ProcessLogRepository extends BeastRepository {

    protected $exceptions = [
        'main' => ProcessLogException::class,
    ];

    /**
     * Retrieves the class instance of the specified repository.
     *
     * @return string the string instance of the defining class
     */
    function getClass()
    {
        return ProcessLog::class;
    }

    /**
     * Log the process in the database
     *
     * @param ProcessQueue $process_queue
     * @param int $runtime the time taken to run the application
     * @param string $run_datetime the datetime that the execution started at
     * @param null|string $error the name of the class of the error
     * @param null|string $error_msg the message attached to the specific error.
     */
    public function create(ProcessQueue $process_queue, $runtime, $run_datetime, $error = null, $error_msg = null) {
        $this->throwErrors(ProcessLog::create([
            'process' => $process_queue->toJson(),
            'run_at' => $run_datetime,
            'completed' => is_null($error)? 1: 0,
            'error_message' => $error_msg,
            'error_type' => $error,
            'runtime' => $runtime
        ]));
    }
}