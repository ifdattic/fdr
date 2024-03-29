<?php

namespace Domain\User\Event;

use Domain\User\Value\UserId;

class UserWasEntered
{
    /** @var UserId */
    private $userId;

    public function __construct(UserId $userId)
    {
        $this->userId = $userId;
    }

    /** @returns UserId */
    public function getUserId()
    {
        return $this->userId;
    }
}
