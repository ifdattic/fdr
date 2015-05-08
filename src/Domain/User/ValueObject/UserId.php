<?php

namespace Domain\User\ValueObject;

use Domain\Core\Identity\Uuid;

class UserId
{
    /** @var Uuid */
    private $uuid;

    public function __construct(Uuid $uuid)
    {
        $this->uuid = $uuid;
    }

    /** @return string */
    public function getValue()
    {
        return $this->uuid->getValue();
    }
}