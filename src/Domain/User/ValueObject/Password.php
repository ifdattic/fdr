<?php

namespace Domain\User\ValueObject;

use Domain\Core\Validation\Assert;

class Password
{
    const LENGTH_MAX = 72;
    const LENGTH_MIN = 8;

    /** @var string */
    private $value;

    /** @param string $value */
    public function __construct($value)
    {
        Assert::notEmpty($value);
        Assert::string($value);
        Assert::minLength($value, self::LENGTH_MIN);
        Assert::maxLength($value, self::LENGTH_MAX);

        $this->value = $value;
    }

    /** @return string */
    public function getValue()
    {
        return $this->value;
    }
}
