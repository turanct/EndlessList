<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Turanct\EndlessList as EndlessList;

// Define fibonacci sequence
//
// We're using the function recursively, because a given position is the sum of the two previous positions.
// Be careful, because if you ask many results, this will eat your CPU alive (because of the recursiveness).
// For a non-recursive example, see fibonacci2.php
//
// f(n) = f(n-1) + f(n-2)
// preconditions:
//    f(0) = 0
//    f(1) = 1
$f = function($position) use (&$f) {
    if ($position === 0) {
        return 0;
    } elseif ($position === 1) {
        return 1;
    } else {
        $sum = 0;
        $sum += $f($position - 1);
        $sum += $f($position - 2);

        return $sum;
    }
};

// Create the fibonacci list, starting at position 0
$list = EndlessList\EndlessListPosition::create(0, $f);

// Get array
var_dump($list->getArray(10));

// [0, 1, 1, 2, 3, 5, 8, 13, 21, 34]
