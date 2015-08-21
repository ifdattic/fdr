<?php

namespace Domain\Task\Value;

use Domain\Core\Validation\Assert;

final class TaskName
{
    const LENGTH_MAX = 1028;

    /** @var string */
    private $value;

    /** @param string $value */
    public function __construct($value)
    {
        Assert::notEmpty($value);
        Assert::string($value);
        Assert::maxLength($value, self::LENGTH_MAX);

        $this->value = $value;
    }

    /** @return string */
    public function getValue()
    {
        return $this->value;
    }
}
