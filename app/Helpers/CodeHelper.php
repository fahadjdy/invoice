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

if (!function_exists('inrFormat')) {
    function inrFormat($number)
    {
        $number = (int)$number;
        $result = '';
        $number = (string)$number;
        $len = strlen($number);

        if ($len > 3) {
            $last3 = substr($number, -3);
            $restUnits = substr($number, 0, $len - 3);
            $restUnits = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $restUnits);
            $result = $restUnits . ',' . $last3;
        } else {
            $result = $number;
        }
        return "₹ ". $result;
    }
}