<?php namespace Nabeghe\Hooker;

class Filter extends Hook
{
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

    public function __construct(string $name, mixed $value, ?array $args = null)
    {
        $this->value = $value;
        parent::__construct($name, $args);
    }
}
