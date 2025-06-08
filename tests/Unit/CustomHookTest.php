<?php declare(strict_types=1);

namespace Nabeghe\Hooker\Tests\Unit;

use Nabeghe\Hooker\Hooker;
use Nabeghe\Hooker\Tests\Fixtures\CustomHook;

class CustomHookTest extends \PHPUnit\Framework\TestCase
{
    public function testCustomHook()
    {
        $hooker = new Hooker();
        $hooker->setHookClass(CustomHook::class);

        $hooker->listen('your_custom_action_name', function (CustomHook $action) use (&$output) {
            $output = $action->url;
        });

        $hooker->action('your_custom_action_name', ['url' => 'https://github.com/nabeghe/hooker']);

        $this->assertSame('https://github.com/nabeghe/hooker', $output);
    }
}