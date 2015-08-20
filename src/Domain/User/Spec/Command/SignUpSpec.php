<?php

namespace Spec\Domain\User\Command;

use Domain\Core\Exception\AssertionFailed;
use Domain\Core\Spec\TestValues;
use Domain\User\ValueObject\Email;
use Domain\User\ValueObject\FullName;
use Domain\User\ValueObject\Password;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SignUpSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(TestValues::EMAIL, TestValues::FULLNAME, TestValues::PASSWORD);
    }

    function it_throws_an_exception_on_invalid_email()
    {
        $this->beConstructedWith(TestValues::INVALID_EMAIL, TestValues::FULLNAME, TestValues::PASSWORD);

        $this
            ->shouldThrow(AssertionFailed::CLASS)
            ->during('getEmail')
        ;
    }

    function it_returns_its_email()
    {
        $this->getEmail()->shouldBeLike(new Email(TestValues::EMAIL));
    }

    function it_returns_its_fullname()
    {
        $this->getFullName()->shouldBeLike(new FullName(TestValues::FULLNAME));
    }

    function it_returns_its_password()
    {
        $this->getPassword()->shouldBeLike(new Password(TestValues::PASSWORD));
    }
}
