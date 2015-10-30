<?php namespace Kevupton\Processor;

use Exception;
use Kevupton\Processor\Exceptions\ProcessException;
use Kevupton\Processor\Models\ProcessQueue;
use Kevupton\Processor\Repositories\ProcessLogRepository;
use Kevupton\Processor\Repositories\ProcessQueueRepository;

class Process  {
    const PACKAGE_FOLDER = 'packages/';
    private $package;
    private $data;
    private $queue_id;
    private $exec_datetime;
    private $process_queue;

    /**
     * @var ProcessLogRepository
     */
    private $process_log;

    /**
     * @var ProcessQueueRepository
     */
    private $queue_repo;
    /**
     * Constructs the class with the row data.
     *
     * @param $row
     * @throws ProcessException
     */
    public function __construct(ProcessQueue $row) {
        try {
            $this->package = $row->package;
            $this->data = $row->data;
            $this->exec_datetime = $row->exec_datetime;
            $this->queue_id = $row->id;
            $this->process_queue = $row;
        } catch (Exception $e) {
            throw new ProcessException("Invalid input data");
        }
        $this->process_log = new ProcessLogRepository();
    }

    /**
     * Gets the package and runs the process from within the package.
     */
    public function execute() {
        $start_at = time();

        $obj = unserialize($this->data);
        if ($obj instanceof Package) {

            $error = null;
            $error_msg = null;
            $exec_time = current_datetime();

            try { //attempt to run the process
                $obj->execute();
                $this->deRegister();
            } catch(Exception $e) {
                $error = get_class($e);
                $error_msg = $e->getMessage();
            }

            $end_at = time();
            $this->process_log->create($this->process_queue, $end_at - $start_at, $exec_time, $error, $error_msg);

        } else throw new ProcessException("Specified package '$this->package' is not an instance of the Package Class.");
    }

    /**
     * De-registers the current process, removing it from the database so that it doesn't actually run again.
     */
    private function deRegister() {
        $this->queue_repo->remove($this->process_queue);
    }

}