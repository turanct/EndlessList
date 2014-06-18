<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Turanct\EndlessList as EndlessList;

// Define fibonacci sequence
//
// We're using two variables to remember the last two results. This way we don't need recursive calculations,
// and as a result, this is way faster than the recursive fibonacci calculator (fibonacci1.php).
// The catch with this one is that we can't start at another position than 0 or 1
//
// f(n) = f(n-1) + f(n-2)
// preconditions:
//    f(0) = 0
//    f(1) = 1
$last = 0;
$beforeLast = 0;

$f = function($position) use (&$last, &$beforeLast) {
    if ($position === 0) {
        $fibonacci = 0;
    } elseif ($position === 1) {
        $fibonacci = 1;
    } else {
        $fibonacci = $last + $beforeLast;
    }

    $beforeLast = $last;
    $last = $fibonacci;

    return $fibonacci;
};

// Create the fibonacci list, starting at position 0
$list = EndlessList\EndlessListPosition::create(0, $f);

// Get array
var_dump($list->getArray(10));

// [0, 1, 1, 2, 3, 5, 8, 13, 21, 34]

