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
     * Filtered value.
     */
    protected mixed $value;

    /**
     * Get filtered value.
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * Changes filtered value.
     * @param  mixed  $value
     */
    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }

    /**
     * @param  mixed|null  $value
     * @return static|mixed
     */
    public function value(mixed $value = null): mixed
    {
        if (func_num_args() === 0) {
            return $this->value;
        }

        $this->value = $value;

        return $this;
    }

    /**
     * Constructor.
     * @param  string  $hookName  Hook name.
     * @param  array  $hookArgs  Optional. Hook arguments. The keys of this array can be accessed through dynamic fields as well as by index. Default null.
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
        return $this->$offset;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->$offset = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        if (isset($this->hookArgs[$offset])) {
            unset($this->hookArgs[$offset]);
        }
    }

    public function &__get(string $name)
    {
        if (!isset($this->hookArgs[$name])) {
            $this->hookArgs[$name] = null;
        }

        return $this->hookArgs[$name];
    }

    public function __set(string $name, $value): void
    {
        $this->hookArgs[$name] = $value;
    }

    public function __call(string $name, array $arguments)
    {
        if (isset($arguments[0])) {
            $this->$name = $arguments[0];
            return $this;
        }

        return $this->$name;
    }
}