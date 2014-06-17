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

##### List: next item based on last item

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Turanct\EndlessList as EndlessList;

// Create a simple list
$list = EndlessList\EndlessListSeries::create(1, function($last) {
	return $last + 1;
});

// Walk through the list with a foreach loop
foreach ($list as $key => $value) {
	// Do something with the generated $value
	// Don't forget to break
}
```

##### List: next item based on position/index

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Turanct\EndlessList as EndlessList;

// Create a simple list
$list = EndlessList\EndlessListPosition::create(1, function($position) {
	return $position * 2;
});

// Walk through the list with a foreach loop
foreach ($list as $key => $value) {
	// Do something with the generated $value
	// Don't forget to break
}
```

##### List: apply a mapping function

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Turanct\EndlessList as EndlessList;

// Create a simple list
$list = EndlessList\EndlessListSeries::create(1, function($last) {
	return $last + 1;
});

// [1, 2, 3, 4, 5, 6, 7, 8, ...]

// Apply a mapper
$mappedList = $list->map(function($value) {
	return $value * 2;
});

// [2, 4, 6, 8, 10, 12, 14, 16, ...]
```

##### List: get a part of the list

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Turanct\EndlessList as EndlessList;

// Create a simple list
$list = EndlessList\EndlessListSeries::create(1, function($last) {
	return $last + 1;
});

// [1, 2, 3, 4, 5, 6, 7, 8, ...]

// Get an array (a part of the infinite list, starting from the beginning)
$part = $list->getArray(4);

// [1, 2, 3, 4]

// Get an array (a part of the infinite list, with an offset)
$part = $list->getArray(4, 2);

// [3, 4, 5, 6]
```

### 3. License

EndlessList is licensed under the *MIT License*
