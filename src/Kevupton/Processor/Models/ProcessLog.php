<?php namespace Kevupton\Processor\Models;


use Kevupton\Ethereal\Models\Ethereal;

class ProcessLog extends Ethereal {
    // table name
    protected $table = 'process_log';
    public $timestamps = true;

    // validation rules
    public static $rules = array(
        'process' => 'required',
        'run_at' => 'required|date',
        'completed' => 'required|numeric',
        'error_message' => 'max:255',
        'error_type' => 'max:255',
        'runtime' => 'required|numeric'
    );

    protected $fillable = array(
        'process', 'run_at', 'completed',
        'error_message', 'error_type', 'runtime',
    );
}
