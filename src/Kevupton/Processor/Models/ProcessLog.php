<?php namespace Kevupton\Processor\Models;


use Kevupton\BeastCore\BeastModel;

class ProcessLog extends BeastModel {
    // table name
    protected $table = 'process_log';

    // validation rules
    public static $rules = array(
        'process' => 'required',
        'run_at' => 'required|date',
        'completed' => 'required|numeric',
        'error_message' => 'required|max:255',
        'error_type' => 'required|max:64',
        'runtime' => 'required|numeric'
    );

    protected $fillable = array(
        'process', 'run_datetime', 'completed',
        'error_message', 'error_type', 'runtime',
    );
}
