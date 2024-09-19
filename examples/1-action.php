<?php require '../vendor/autoload.php';

use Nabeghe\Hooker\Hooker;
use Nabeghe\Hooker\Action;

$hooker = new Hooker();

$hooker->setDefaultArgToHooks('protocol', 'https://');

$hooker->listen('your_custom_action_name', function (Action $action) {
    echo 'Priority 2: '.$action['protocol'].$action['url'].PHP_EOL;
}, 2); // priority 2

$hooker->listen('your_custom_action_name', function (Action $action) {
    echo 'Priority 4: '.$action['protocol'].$action['url'].PHP_EOL;
}, 4); // priority 4

$hooker->listen('your_custom_action_name', function (Action $action) {
    echo 'Priority 3: '.$action['protocol'].$action['url'].PHP_EOL;
}, 3); // priority 3

$hooker->listen('your_custom_action_name', function (Action $action) {
    echo 'Priority 1: '.$action['protocol'].$action['url'].PHP_EOL;
}, 1); // priority 1

$hooker->listen('your_custom_action_name', function (Action $action) {
    echo 'Priority 5: '.$action['protocol'].$action['url'].PHP_EOL;
}, 5); // priority 5

$hooker->action('your_custom_action_name', ['url' => 'https://github.com/nabeghe/hooker']);