<?php namespace Kevupton\Processor\Models;

use Kevupton\Ethereal\Models\Ethereal;

class ProcessQueue extends Ethereal {
    // table name
    protected $table = 'process_queue';
    public $timestamps = true;

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
