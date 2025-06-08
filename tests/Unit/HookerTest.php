<?php declare(strict_types=1);

namespace Nabeghe\Hooker\Tests\Unit;

use Nabeghe\Hooker\Hooker;

use Nabeghe\Hooker\Hook;
use Nabeghe\Hooker\Tests\Fixtures\CustomHooker;

class HookerTest extends \PHPUnit\Framework\TestCase
{
    /** @noinspection PhpUndefinedFieldInspection */
    public function testAction()
    {
        $output = '';

        $hooker = new Hooker();

        $hooker->setDefaultArgToHooks('github_username', 'nabeghe');

        $hooker->listen('your_custom_action_name', function (Hook $action) use (&$output) {
            $output .= 'Callback 1: https://github.com/'.$action['github_username'].'/'.$action['repository_name']."\n";
        }, 2); // priority 2

        $hooker->listen('your_custom_action_name', function (Hook $action) use (&$output) {
            $output .= 'Callback 2: https://github.com/'.$action->github_username.'/'.$action->repository_name."\n";
        }, 4); // priority 4

        $hooker->listen('your_custom_action_name', function (Hook $action) use (&$output) {
            $output .= 'Callback 3: https://github.com/'.$action['github_username'].'/'.$action['repository_name']."\n";
        }, 3); // priority 3

        $hooker->listen('your_custom_action_name', function (Hook $action) use (&$output) {
            $output .= 'Callback 4: https://github.com/'.$action['github_username'].'/'.$action['repository_name']."\n";
        }, 1); // priority 1

        $hooker->listen('your_custom_action_name', function (Hook $action) use (&$output) {
            $output .= 'Callback 5: https://github.com/'.$action['github_username'].'/'.$action['repository_name']."\n";
        }, 5); // priority 5

        $hooker->action('your_custom_action_name', ['repository_name' => 'hooker']);

        $output = trim($output);

        $this->assertSame(
            trim(<<<EOD
            Callback 5: https://github.com/nabeghe/hooker
            Callback 2: https://github.com/nabeghe/hooker
            Callback 3: https://github.com/nabeghe/hooker
            Callback 1: https://github.com/nabeghe/hooker
            Callback 4: https://github.com/nabeghe/hooker
            EOD), $output
        );
    }

    public function testFilter()
    {
        $hooker = new Hooker();

        $hooker->listen('your_custom_filter_name', function (Hook $filter) {
            if ($filter->getValue() === null) {
                $filter->setValue($filter['default']);
            }
        });

        $hooker->listen('your_custom_filter_name', function (Hook $filter) {
            $filter->setValue($filter->getValue() + 2);
        });

        $hooker->listen('your_custom_filter_name', function (Hook $filter) {
            $filter->setValue($filter->getValue() + 3);
        });

        $value = $hooker->filter('your_custom_filter_name', null, ['default' => 8]);

        $this->assertSame(13, $value);
    }

    public function testFilterDefault()
    {
        $hooker = new Hooker();

        $hooker->listen('your_custom_filter_name', function (Hook $filter) {
            if ($filter->getValue() === null) {
                $filter->setValue(9 + $filter['default']);
            }
        });

        $value = $hooker->filter('your_custom_filter_name', null, ['default' => 5]);

        $this->assertSame(14, $value);
    }

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