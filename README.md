# Hooker for PHP

> A simple hook system library (actions and filters) based on Symfony EventDispatcher.

## 🫡 Usage

### 🚀 Installation

You can install the package via composer:

```bash
composer require nabeghe/hooker
```

### Examples

Check the examples folder in the repositiry.

#### Action

```php
require 'vendor/autoload.php';

use Nabeghe\Hooker\Hooker;
use Nabeghe\Hooker\Hook;

$hooker = new Hooker();

$hooker->setDefaultArgToHooks('protocol', 'https://');

$hooker->listen('your_custom_action_name', function (Hook $action) {
    echo $action['protocol'].$action['url'].PHP_EOL;
}, 2);

$hooker->action('your_custom_action_name', ['url' => 'https://github.com/nabeghe/hooker']);
```

#### Filter:

```php
require 'vendor/autoload.php';

use Nabeghe\Hooker\Hooker;
use Nabeghe\Hooker\Hook;

$hooker = new Hooker();

$hooker->listen('your_custom_filter_name', function (Hook $filter) {
    if ($filter->getValue() === null) {
        $filter->setValue(8 + $filter['default']);
    }
});

$value = $hooker->filter('your_custom_filter_name', null, ['default' => 5]);
echo $value; // 13
```