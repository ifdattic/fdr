<?php

namespace Domain\Task\ValueObject;

use Domain\Core\Validation\Assert;

final class Done
{
    const DEFAULT_VALUE = false;

    /** @var boolean */
    private $value;

    /** @param boolean|null $value */
    public function __construct($value = null)
    {
        if (null === $value) {
            $value = self::DEFAULT_VALUE;
        }

        Assert::boolean($value);

        $this->value = (bool) $value;
    }

    /** @return boolean */
    public function getValue()
    {
        return $this->value;
    }
}
