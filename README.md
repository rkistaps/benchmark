# PHP benchmark 
A micro benchmark library for php

Install
---
```
composer require rkistaps/benchmark
```

Use
--- 
Simple unnamed usage
```
<?php

use rkistaps\benchmark\Benchmark;

require 'vendor/autoload.php';

$bench = new Benchmark();

$bench->start();

// do some heavy processing

$result = $bench->end();

echo $result->getReadableTime(); // Output: 2 secs
```
Nesting and naming benchmarks
```
<?php

use rkistaps\benchmark\Benchmark;

require 'vendor/autoload.php';

$bench = new Benchmark();
 
$bench->start('outter');
// do some heavy processing

$bench->start('inner');
// process inner task

$innerResult = $bench->end('inner');
$outterResult = $bench->end('outter');

echo $innerResult->getReadableTime(); // Output inner time: 2 secs
echo $outterResult->getReadableTime(); // Output total time: 4 secs
```

Develop
---

1. Clone
```
git clone https://github.com/rkistaps/benchmark.git .
```

2. Install dependencies
```
composer install --dev
```

3. Run tests
```
./vendor/bin/phpunit tests
```
