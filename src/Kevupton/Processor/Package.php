<?php namespace Kevupton\Processor;

use Illuminate\Queue\SerializesModels;
use Kevupton\Processor\Exceptions\ProcessException;
use Kevupton\Processor\Validator\ProcessValidator;
use ReflectionClass;
use Serializable;
use stdClass;

abstract class Package implements Serializable {
    protected $validation = array();

    use SerializesModels;

    /**
     * Validates the class requirements with the input data.
     */
    private function validate() {
        $validator = new ProcessValidator($this->getData(), $this->validation);
        if ($validator->fails()) {
            throw new ProcessException($validator->getErrors("\n"));
        }
    }

    /**
     * Fills the package  with the specific data.
     *
     * @param stdClass|array $data
     */
    public function fill($data = array()) {
        $data = (array) $data;
        foreach ($data as $key => $val) {
            $this->$key = $val;
        }
    }

    /**
     * Executes the package script
     */
    public final function execute() {
        $this->validate();
        $this->main();
    }

    /**
     * The main location for all of the package logic to go.
     */
    public abstract function main();

    /**
     * Returns the class name as a string
     *
     * @returns string class name
     */
    protected function className() {
        return get_class($this);
    }

    /**
     * Register the process to go again at a specified time with the optional new input data.
     *
     * @param int|string $run_datetime either a string of the future datetime, or an int representing the minutes after the current datetime
     * @param array $new_data an option array of new data to be added to the class
     * @throws ProcessException if the run_datetime is invalid
     */
    protected function goAgain($run_datetime, array $new_data = array()) {
        $this->fill($new_data);
        Processor::register($this, $run_datetime);
    }

    /**
     * Overrides the object to store all information in the data
     *
     * @param string $key the key to fetch within the data
     * @return null|mixed null if nothing is found, else the keys value
     */
    public function __get($key) {
        return $this->get($key);
    }

    public function get($key) {
        if (isset($this->$key)) {
            return $this->$key;
        } else return null;
    }

    /**
     * Returns the data as an array
     *
     * @return array the data attached to the object
     */
    public function getData() {
        $data = array();
        foreach ($this as $key => $val) {
            $data[$key] = $val;
        }
        return $data;
    }

    /**
     * Returns the data as a JSON string
     *
     * @return string
     */
    public function toJSON() {
        return json_encode($this->getData());
    }

    /**
     * Returns the object's data as a json_encoded string
     */
    public function __toString() {
        return $this->toJSON();
    }
}