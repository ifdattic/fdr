<?php

namespace Spec\Domain\User\Entity;

use Domain\Core\Identity\Uuid;
use Domain\Core\Spec\TestValues;
use Domain\User\Entity\User;
use Domain\User\Value\Email;
use Domain\User\Value\FullName;
use Domain\User\Value\PasswordHash;
use Domain\User\Value\UserId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(
            new UserId(new Uuid(TestValues::UUID)),
            new Email(TestValues::EMAIL),
            new FullName(TestValues::FULLNAME),
            new PasswordHash(TestValues::PASSWORD_HASH)
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(User::CLASS);
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
