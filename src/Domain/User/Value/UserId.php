<?php

namespace Domain\User\Value;

use Domain\Core\Identity\Uuid;

final class UserId
{
    /** @var Uuid */
    private $uuid;

    public function __construct(Uuid $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @param  string $uuid
     * @return self
     */
    public static function createFromString($uuid)
    {
        $uuid = new Uuid($uuid);

        return new self($uuid);
    }

    /** @return string */
    public function getValue()
    {
        return $this->uuid->getValue();
    }

    /** @return string */
    public function __toString()
    {
        return $this->getValue();
    }
}
