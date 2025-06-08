<?php declare(strict_types=1);

namespace Nabeghe\Hooker\Tests\Unit;

use Nabeghe\Hooker\Hook;
use Nabeghe\Hooker\Tests\Fixtures\CustomHooker;

class CustomHookerTest extends \PHPUnit\Framework\TestCase
{
    public function testCustomHooker()
    {
        $hooker = new CustomHooker();

        $hooker->listen('your_custom_action_name', function (Hook $action) use (&$ouoput) {
            $ouoput = $action['url'];
        });

        $hooker->action('your_custom_action_name', ['url' => 'https://github.com/nabeghe/hooker']);

        $this->assertSame('https://github.com/nabeghe/hooker', $ouoput);
    }
}