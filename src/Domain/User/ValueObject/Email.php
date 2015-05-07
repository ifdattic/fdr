<?php

namespace Domain\User\ValueObject;

use Domain\Core\Validation\Assert;

final class Email
{
    /** @var string */
    private $value;

    /** @param string $value */
    public function __construct($value)
    {
        Assert::notEmpty($value);
        Assert::email($value);

        $this->value = $value;
    }

    /** @return string */
    public function getValue()
    {
        return $this->value;
    }
}
