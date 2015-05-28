<?php

namespace Domain\Task\ValueObject;

use Domain\Core\Validation\Assert;

final class Estimated
{
    const DEFAULT_VALUE = 1;
    const MIN = 0;

    /** @var string */
    private $value;

    /** @param string $value */
    public function __construct($value = self::DEFAULT_VALUE)
    {
        Assert::integer($value);
        Assert::min($value, self::MIN);

        $this->value = (int) $value;
    }

    /** @return string */
    public function getValue()
    {
        return $this->value;
    }
}
