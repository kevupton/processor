<?php


if (!function_exists('add_time')) {
    /**
     * Adds time to the current time and returns it in a numeric time
     *
     * @param $time string|int the string or numeric representation of time.
     * @return int
     */
    function add_time($time) {
        return date(mysql_datetime_format(), strtotime(current_datetime() . " $time"));
    }
}