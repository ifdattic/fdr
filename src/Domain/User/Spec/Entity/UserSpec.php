<?php

namespace Spec\Domain\User\Entity;

use Domain\Core\Identity\Uuid;
use Domain\User\ValueObject\Email;
use Domain\User\ValueObject\FullName;
use Domain\User\ValueObject\PasswordHash;
use Domain\User\ValueObject\UserId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserSpec extends ObjectBehavior
{
    const VALID_EMAIL         = 'email@valid.com';
    const VALID_FULLNAME      = 'Full Name';
    const VALID_PASSWORD_HASH = '$2y$14$2RfLwLL./bzTyfNdBRaotelrsmoOR61yUcDTOIDT84VwvvvZA7zJW';
    const VALID_UUID          = '5399dbab-ccd0-493c-be1a-67300de1671f';

    function let()
    {
        $this->beConstructedWith(
            new UserId(new Uuid(self::VALID_UUID)),
            new Email(self::VALID_EMAIL),
            new FullName(self::VALID_FULLNAME),
            new PasswordHash(self::VALID_PASSWORD_HASH)
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Domain\User\Entity\User');
    }

    function it_returns_its_id()
    {
        $this->getId()->shouldHaveType(UserId::CLASS);
    }

    function it_returns_its_email()
    {
        $this->getEmail()->shouldHaveType(Email::CLASS);
    }

    function it_returns_its_fullname()
    {
        $this->getFullName()->shouldHaveType(FullName::CLASS);
    }

    function it_returns_its_created_at()
    {
        $this->getCreatedAt()->shouldHaveType(\DateTime::CLASS);
    }

    function it_returns_its_password()
    {
        $this->getPassword()->shouldHaveType(PasswordHash::CLASS);
    }
}
