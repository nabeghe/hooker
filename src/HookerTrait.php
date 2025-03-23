<?php namespace Nabeghe\Hooker;

use Symfony\Component\EventDispatcher\EventDispatcher;

trait HookerTrait
{
    protected ?EventDispatcher $dispatcher = null;

    protected string $hookClass = Hook::class;

    protected array $hooksDefaultArgs = [];

    private function initHookerTrait(): void
    {
        if (!isset($this->dispatcher)) {
            $this->dispatcher = new EventDispatcher();
        }
    }

    public function getHookClass(string $actionClass): string
    {
        return $this->hookClass;
    }

    public function setHookClass(string $hookClass): void
    {
        $this->hookClass = $hookClass;
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

        $action_class = $this->hookClass;
        $this->dispatcher->dispatch(new $action_class($name, $args), $name);
    }

    public function filter(string $name, mixed $value, array $args = []): mixed
    {
        $this->initHookerTrait();
        $this->modifyHookArgs($args);

        $filter_class = $this->hookClass;
        $filter = new $filter_class($name, $args);
        $filter->setValue($value);
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