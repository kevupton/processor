<?php


if (!function_exists('add_time')) {
    /**
     * Adds time to the current time and returns it in a numeric time
     *
     * @param $time string|int the string or numeric representation of time.
     * @return int
     */
    function add_time($time) {
        return date(mysql_datetime_format(), strtotime(current_datetime() . " + $time"));
    }
}

if (!function_exists('next_hour')) {
    /**
     * Gets the next hour in mysql datetime format
     *
     * @param null|string $time the time of to add 1 hour
     * @return bool|string
     */
    function next_hour($time = null) {
        $format = "Y-m-d H:00:00";
        if ($time == null)
            return date("Y-m-d H:00:00", strtotime("next hour"));
        else
            return date("Y-m-d H:00:00", strtotime("$time + 1 hour"));
    }
}