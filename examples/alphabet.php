<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Turanct\EndlessList as EndlessList;

// This will generate an endless list of characters of the alphabet
$f = function($last) {
    $alphabet = array(
        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
        'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
    );

    if ($last === 'z') {
        $key = 0;
    } else {
        $key = array_search($last, $alphabet) + 1;
    }

    return $alphabet[$key];
};

// Create the alphabet list, starting with a
$list = EndlessList\EndlessListSeries::create('a', $f);

// Get array
var_dump($list->getArray(35));

// [a, b, c, d, e, f, g, h, i, j, k, l, m, n, o, p, q, r, s, t, u, v, w, x, y, z, a, b, c, d, e, f, g, h, i]
