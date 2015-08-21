<?php

namespace Domain\Core\Value;

use Domain\Core\Validation\Assert;

final class Description
{
    /** @var string */
    private $value;

    /** @param string|null $value */
    public function __construct($value = null)
    {
        if (null !== $value) {
            Assert::string($value);
        }

        $this->value = $value;
    }

    /** @return string */
    public function getValue()
    {
        return $this->value;
    }
}
