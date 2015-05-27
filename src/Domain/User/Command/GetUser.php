<?php

namespace Domain\User\Command;

use Domain\User\Entity\User;
use Domain\User\ValueObject\UserId;

class GetUser
{
    /** @var string */
    private $userId;

    /** @var User */
    private $user;

    /** @param string $userId */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /** @return UserId */
    public function getUserId()
    {
        return UserId::createFromString($this->userId);
    }

    /**
     * @return User
     * @throws \RuntimeException if user is not set
     */
    public function getUser()
    {
        if (null === $this->user) {
            throw new \RuntimeException('User not set');
        }

        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }
}
