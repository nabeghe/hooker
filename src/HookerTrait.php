<?php namespace Nabeghe\Hooker;

use Symfony\Component\EventDispatcher\EventDispatcher;

trait HookerTrait
{
    protected ?EventDispatcher $dispatcher = null;
    private array $hooksDefaultArgs = [];

    private function initHookerTrait(): void
    {
        if (!isset($this->dispatcher)) {
            $this->dispatcher = new EventDispatcher();
        }
    }

    public function setDefaultArgToHooks(mixed $name, mixed $value): void
    {
        $this->hooksDefaultArgs[$name] = $value;
    }

    public function removeDefaultArgFromHooks(mixed $name, mixed $value): void
    {
        unset($this->hooksDefaultArgs[$name]);
    }

    public function clearHooksDefaultArgs(mixed $name, mixed $value): void
    {
        $this->hooksDefaultArgs = [];
    }

    private function modifyHookArgs(array &$args): void
    {
        if ($this->hooksDefaultArgs) {
            foreach ($this->hooksDefaultArgs as $name => $value) {
                $args[$name] = $value;
            }
        }
    }

    public function action(string $name, ?array $args = []): void
    {
        $this->initHookerTrait();
        $this->modifyHookArgs($args);
        $this->dispatcher->dispatch(new Action($name, $args), $name);
    }

    public function filter(string $name, mixed $value, array $args = []): mixed
    {
        $this->initHookerTrait();
        $this->modifyHookArgs($args);
        $filter = new Filter($name, $value, $args);
        $filter = $this->dispatcher->dispatch($filter, $name);
        return $filter->getValue();
    }

    public function listen(string $eventName, callable|array $listener, int $priority = 0): void
    {
        $this->initHookerTrait();
        $this->dispatcher->addListener($eventName, $listener, $priority);
    }

    public function addAction(string $name, callable|array $callback, int $priority = 0): void
    {
        $this->listen($name, $callback, $priority);
    }

    public function addFilter(string $name, callable|array $callback, int $priority = 0): void
    {
        $this->listen($name, $callback, $priority);
    }
}