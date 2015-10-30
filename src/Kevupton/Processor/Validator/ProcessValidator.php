<?php namespace Kevupton\Processor\Validator;

use Kevupton\Processor\Exceptions\ProcessValidatorException;

class ProcessValidator {
    private $rules;
    private $inputs;
    private $errors = array();

    /**
     * Constructs the initial validator and performs the validation check
     *
     * @param array $inputs the inputs to validate with a key => value pair
     * @param array $rules the rules containing the requirements of each key
     * @throws ProcessValidatorException if a rule is not found
     */
    public function __construct(array $inputs, array $rules) {
        $this->inputs = $inputs;
        $this->rules = $rules;
        $this->validate();
    }


    /**
     * Validates the inputs against the specified rules.
     *
     * @throws ProcessValidatorException
     */
    private function validate() {
        foreach ($this->rules as $key => $rules) {
            $rules = explode('|', $rules);
            foreach ($rules as $rule) {
                $val = (isset($this->inputs[$key]))? $this->inputs[$key]: null;
                if (method_exists($this, '_' . strtolower($rule))) {
                    $this->{'_'.$rule}($key, $val);
                } else {
                    throw new ProcessValidatorException("Method _$rule not found");
                }
            }
        }
    }

    /**
     * Checks if the validation requirements were successful
     *
     * @return bool true if the validation was successful
     */
    public function passes() {
        return count($this->errors) == 0;
    }

    /**
     * Checks if the validation requirements were unsuccessful
     *
     * @return bool true if the validation was unsuccessful
     */
    public function fails() {
        return count($this->errors) > 0;
    }

    /**
     * Gets the errors as an array
     *
     * @return array the list of errors
     */
    public function errors() {
        return $this->errors();
    }

    /**
     * Gets the errors as a string.
     *
     * @param string $join the merging value to merge all errors on.
     * @return string the joined errors.
     */
    public function getErrors($join = '') {
        return implode($join, $this->errors);
    }

    /**
     * Validates that the field exists
     *
     * @param string $key the key of the field to search
     * @param mixed $val the value of the field to validate
     */
    private function _required($key, $val) {
        if (is_null($val) || empty($val))
            $this->errors[] = "The $key field is required.";
    }

    /**
     * Validates that the field exists
     *
     * @param string $key the key of the field to search
     * @param mixed $val the value of the field to validate
     */
    private function _numeric($key, $val) {
        if (!is_numeric($val))
            $this->errors[] = "The $key field must be numeric.";
    }
}