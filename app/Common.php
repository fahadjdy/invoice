<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */


 function convertSquareInchesToSquareFeet($squareInches) {
    // Ensure the input is a valid number
    if (!is_numeric($squareInches) || $squareInches < 0) {
        throw new InvalidArgumentException('Input must be a non-negative number.');
    }

    // Conversion factor: 1 square foot = 144 square inches
    $squareFeet = $squareInches / 144;
    
    return $squareFeet;
}