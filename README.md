EndlessList
========================================

Implement endless lists in php.


1. Goals & Accomplishments
----------------------------------------

### 1.1 Goals

- Create endless lists, like you can in Haskell with list comprehensions
- Make it possible to apply mapping functions on those endless lists
- Work with list objects as iterator or as array


2. Getting started
----------------------------------------

### 2.1 Requirements

- php 5.3
- composer


### 2.2 Usage

#### 1. Install this package in your project using composer

in your `composer.json` file:

```json
{
	"repositories": [
		{
			"type": "vcs",
			"url": "https://github.com/turanct/EndlessList.git"
		}
	]
	"require": {
		"turanct/endlesslist": "master"
	}
}
```

#### 2. Require the composer autoloader in your project

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';
```

#### 3. Create a new list

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Turanct\EndlessList as EndlessList;

// Create a simple list
$testList = EndlessList\EndlessListSeries::create(1, function($last) {
	return $last + 1;
});

// Apply a mapper
$mappedList = $testList->map(function($value) {
	return $value * 2;
});

// Walk through the list with a foreach loop
foreach ($mappedList as $key => $value) {
	// Do something with the generated $value
	// Don't forget to break
}

// Get an array (a part of the infinite list)
$part = $mappedList->getArray(30);
```

### 3. License

EndlessList is licensed under the *MIT License*
