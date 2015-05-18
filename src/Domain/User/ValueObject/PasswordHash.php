<?php

namespace Domain\User\ValueObject;

use Domain\Core\Validation\Assert;

class PasswordHash
{
    const LENGTH = 60;

    /** @var string */
    private $value;

    /** @param string $value */
    public function __construct($value)
    {
        Assert::notEmpty($value);
        Assert::length($value, self::LENGTH);

        $this->value = $value;
    }

    /** @return string */
    public function getValue()
    {
        return $this->value;
    }
}
