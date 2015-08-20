<?php

namespace Domain\User\Command;

use Domain\Core\Validation\HasErrors;
use Domain\User\ValueObject\Email;
use Domain\User\ValueObject\FullName;
use Domain\User\ValueObject\Password;

class SignUp
{
    use HasErrors;

    /** @var string */
    private $email;

    /** @var string */
    private $fullName;

    /** @var string */
    private $password;

    /**
     * @param string $email
     * @param string $fullName
     * @param string $password
     */
    public function __construct($email, $fullName, $password)
    {
        $this->email = $email;
        $this->fullName = $fullName;
        $this->password = $password;
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

    /** @return Password */
    public function getPassword()
    {
        return new Password($this->password);
    }
}
