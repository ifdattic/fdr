<?php

namespace Domain\User\Command;

use Domain\Core\Validation\HasErrorsTrait;
use Domain\User\ValueObject\Email;
use Domain\User\ValueObject\FullName;

class SignUp
{
    use HasErrorsTrait;

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
        $this->email = $email;
        $this->fullName = $fullName;
    }

    /** @return Email */
    public function getEmail()
    {
        return new Email($this->email);
    }

    /** @return FullName */
    public function getFullName()
    {
        return new FullName($this->fullName);
    }
}
