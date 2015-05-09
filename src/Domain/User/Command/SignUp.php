<?php

namespace Domain\User\Command;

use Domain\User\ValueObject\Email;
use Domain\User\ValueObject\FullName;

class SignUp
{
    /** @var string */
    private $email;

    /** @var string */
    private $fullName;

    /**
     * @param string $email
     * @param string $fullName
     */
    public function __construct($email, $fullName)
    {
        $this->email = new Email($email);
        $this->fullName = new FullName($fullName);
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
