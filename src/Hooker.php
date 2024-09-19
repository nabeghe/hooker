<?php namespace Nabeghe\Hooker;

use Symfony\Component\EventDispatcher\EventDispatcher;

class Hooker
{
    use HookerTrait;

    public function __construct(?EventDispatcher $dispatcher = null)
    {
        $this->dispatcher = $dispatcher;
    }
}