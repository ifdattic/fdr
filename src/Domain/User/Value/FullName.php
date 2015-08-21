<?php

namespace Domain\User\Value;

use Domain\Core\Validation\Assert;

final class FullName
{
    /** @var string */
    private $value;

    /** @param string $value */
    public function __construct($value)
    {
        Assert::notEmpty($value);
        Assert::string($value);

        $this->value = $value;
    }

    /** @return string */
    public function getValue()
    {
        return $this->value;
    }
}
