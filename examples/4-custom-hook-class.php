<?php require '../vendor/autoload.php';

use Nabeghe\Hooker\Hooker;
use Nabeghe\Hooker\Hook;

/**
 *
 * @property ?string $url
 *
 * @method string|null url(?string $value)
 */
class CustomHook extends Hook
{
}

$hooker = new Hooker();
$hooker->setHookClass(CustomHook::class);

$hooker->listen('your_custom_action_name', function (CustomHook $action) {
    echo $action->url.PHP_EOL;
});

$hooker->action('your_custom_action_name', ['url' => 'https://github.com/nabeghe/hooker']);