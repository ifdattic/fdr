<?php

namespace Domain\User\Entity;

use Domain\User\ValueObject\Email;
use Domain\User\ValueObject\FullName;
use Domain\User\ValueObject\UserId;

class User
{
    /** @var UserId */
    private $id;

    /** @var Email */
    private $email;

    /** @var FullName */
    private $fullName;

    public function __construct(UserId $id, Email $email, FullName $fullName)
    {
        $this->id = $id;
        $this->email = $email;
        $this->fullName = $fullName;
    }

    /** @return UserId */
    public function getId()
    {
        return $this->id;
    }

    /** @return Email */
    public function getEmail()
    {
        return $this->email;
    }

    /** @return FullName */
    public function getFullName()
    {
        return $this->fullName;
    }
}
