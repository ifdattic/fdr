<?php

namespace Domain\Core\Identity;

use Domain\Core\Validation\Assert;
use Ramsey\Uuid\Uuid as RUuid;

final class Uuid
{
    /** @var string */
    private $value;

    /** @param string $value */
    public function __construct($value)
    {
        Assert::uuid($value);

        $this->value = $value;
    }

    /** @return string */
    public function getValue()
    {
        return $this->value;
    }

    /** @return Uuid */
    public static function generate()
    {
        return new self((string) RUuid::uuid4());
    }
}
