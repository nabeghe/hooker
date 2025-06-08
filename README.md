# Hooker for PHP

<p align="center">
    <img src="https://github.com/user-attachments/assets/904b09e6-520b-488e-b060-114b54dbdc64" width="400"/>
</p>

> A simple hook system library (actions and filters) based on Symfony EventDispatcher.

## 🫡 Usage

### 🚀 Installation

You can install the package via composer:

```bash
composer require nabeghe/hooker
```

### Examples

#### Action 

```php
require 'vendor/autoload.php';

use Nabeghe\Hooker\Hooker;
use Nabeghe\Hooker\Hook;

$hooker = new Hooker();

$hooker->setDefaultArgToHooks('protocol', 'https://');

$hooker->listen('your_custom_action_name', function (Hook $action) {
    echo $action['protocol'].$action['url'].PHP_EOL;
}, 2); // priority = 2

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

## 📖 License

Copyright (c) Hadi Akbarzadeh

Licensed under the MIT license, see [LICENSE.md](LICENSE.md) for details.