<?php

namespace Domain\Core\ValueObject;

use Domain\Core\Validation\Assert;

final class Description
{
    /** @var string */
    private $value;

    /** @param string $value */
    public function __construct($value = '')
    {
        Assert::string($value);

        $this->value = $value;
    }

    /** @return string */
    public function getValue()
    {
        return $this->value;
    }
}
