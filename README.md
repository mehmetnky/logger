# Logger
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

A lightweight PSR-3 logger

## Installation

``` bash
$ composer require mehmetnky/logger
```

## Usage
``` php
use Mehmetnky\Logger\Logger;

// Creates an "app.log" file in root folder.
$logger = new Logger();
// Or you can specify a path for your log file.
$logger = new Logger('custom/path/to/my.log');

$logger->emergency('Log message', ['additional', 'information']);
$logger->alert('Log message', ['additional', 'information']);
$logger->critical('Log message', ['additional', 'information']);
$logger->error('Log message', ['additional', 'information']);
$logger->warning('Log message', ['additional', 'information']);
$logger->notice('Log message', ['additional', 'information']);
$logger->info('Log message', ['additional', 'information']);
$logger->debug('Log message', ['additional', 'information']);

/* A Sample Log
[2023-02-27 11:06:34] DEBUG: Log message
MoreInfo:
0: additional
1: information
*/
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
