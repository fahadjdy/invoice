<?php

if (!function_exists('greet')) {
    function greet($name)
    {
        return "Hello, {$name}!";
    }
}

if (!function_exists('dateFormat')) {
    function dateFormat($date)
    {
        return date('d-M-Y', strtotime($date));
    }
}