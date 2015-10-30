<?php namespace Kevupton\Processor\Models;


use Kevupton\BeastCore\BeastModel;

class ProcessQueue extends BeastModel {
    // table name
    protected $table = 'process_queue';

    // validation rules
    public static $rules = array(
        'package' => 'required|max:255',
        'exec_datetime' => 'required|date',
        'category' => 'max:64'
    );

    protected $fillable = array(
        'package', 'exec_datetime', 'data', 'category'
    );
}
