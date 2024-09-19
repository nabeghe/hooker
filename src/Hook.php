<?php namespace Nabeghe\Hooker;

#[\AllowDynamicProperties]
class Hook extends \Symfony\Contracts\EventDispatcher\Event implements \ArrayAccess
{
    /**
     * Gets the hook name.
     * @return string
     */
    public function hookName(): string
    {
        return $this->hookName;
    }

    /**
     * Constructor.
     * @param  string  $hookName Hook name.
     * @param  array|null  $hookArgs Optional. Hook arguments. The keys of this array can be accessed through dynamic fields as well as by index. Default null.
     * @param  \Tueen\Tueen|null  $bot Optional. Bot object. Default null.
     */
    public function __construct(protected string $hookName, protected array $hookArgs = [])
    {
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->hookArgs[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->hookArgs[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->hookArgs[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->$offset);
    }

    public function __get(string $name)
    {
        return $this->hookArgs[$name] ?? null;
    }

    public function __set(string $name, $value): void
    {
        $this->hookArgs[$name] = $value;
    }

    public function __call(string $name, array $arguments)
    {
        if (isset($arguments[0])) {
            $this->hookArgs[$name] = $arguments[0];
            return $this;
        }
        return $this->hookArgs[$name] ?? null;
    }
}