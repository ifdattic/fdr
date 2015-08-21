<?php

namespace Domain\User\Security;

use Domain\User\Value\Password;
use Domain\User\Value\PasswordHash;

class PasswordEncoder
{
    /** @var int */
    private $cost;

    /** @param int $cost */
    public function __construct($cost)
    {
        $cost = (int) $cost;

        if ($cost < 4 || $cost > 31) {
            throw new \InvalidArgumentException('Cost must be in the range of 4-31.');
        }

        $this->cost = $cost;
    }

    /** @return PasswordHash */
    public function encodePassword(Password $password)
    {
        $options = ['cost' => $this->cost];
        $passwordHash = password_hash($password->getValue(), PASSWORD_BCRYPT, $options);

        return new PasswordHash($passwordHash);
    }
}
