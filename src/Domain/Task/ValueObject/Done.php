<?php

namespace Domain\Task\ValueObject;

use Domain\Core\Validation\Assert;

final class Done
{
    const DEFAULT_VALUE = false;

    /** @var string */
    private $value;

    /** @param string $value */
    public function __construct($value = self::DEFAULT_VALUE)
    {
        Assert::boolean($value);

        $this->value = (bool) $value;
    }

    /** @return string */
    public function getValue()
    {
        return $this->value;
    }
}
