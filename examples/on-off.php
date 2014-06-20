<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Turanct\EndlessList as EndlessList;

// This will generate an endless list of 1, 0, 1, 0, ...
$f = function($last) {
    return ($last === 1) ? 0 : 1;
};

// Create the alphabet list, starting with a
$list = EndlessList\EndlessListSeries::create(1, $f);

// Get array
var_dump($negative->getArray(10));

// [1, 0, 1, 0, 1, 0, 1, 0, 1, 0]
