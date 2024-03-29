<?php

namespace Domain\Task\Value;

use Domain\Core\Validation\Assert;

final class TimeSpent
{
    const DEFAULT_VALUE = 0;
    const MIN = 0;

    /** @var integer */
    private $value;

    /** @param integer|null $value */
    public function __construct($value = null)
    {
        if (null === $value) {
            $value = self::DEFAULT_VALUE;
        }

        Assert::integer($value);
        Assert::min($value, self::MIN);

        $this->value = (int) $value;
    }

    /** @return integer */
    public function getValue()
    {
        return $this->value;
    }
}
