<?php require '../vendor/autoload.php';

use Nabeghe\Hooker\Action;

class CustomHooker
{
    use \Nabeghe\Hooker\HookerTrait;
}

$hooker = new CustomHooker();

$hooker->listen('your_custom_action_name', function (Action $action) {
    echo $action['url'].PHP_EOL;
});

$hooker->action('your_custom_action_name', ['url' => 'https://github.com/nabeghe/hooker']);