<?php

namespace Domain\Task\ValueObject;

use Domain\Core\Validation\Assert;

final class Estimated
{
    const DEFAULT_VALUE = 1;
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
