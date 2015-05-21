<?php

namespace Spec\Domain\User\Command;

use Domain\Core\Exception\AssertionFailedException;
use Domain\User\ValueObject\Email;
use Domain\User\ValueObject\FullName;
use Domain\User\ValueObject\Password;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SignUpSpec extends ObjectBehavior
{
    const EMAIL    = 'virgil@mundell.com';
    const FULLNAME = 'Virgil Mundell';
    const PASSWORD = '9wt24yk^T&ObwHDQ2bbDej3kZ^Llz@';

    function let()
    {
        $this->beConstructedWith(self::EMAIL, self::FULLNAME, self::PASSWORD);
    }

    function it_throws_an_exception_on_invalid_email()
    {
        $this->beConstructedWith('invalid', self::FULLNAME, self::PASSWORD);

        $this
            ->shouldThrow(AssertionFailedException::CLASS)
            ->during('getEmail')
        ;
    }

    function it_returns_its_email()
    {
        $this->getEmail()->shouldBeLike(new Email(self::EMAIL));
    }

    function it_returns_its_fullname()
    {
        $this->getFullName()->shouldBeLike(new FullName(self::FULLNAME));
    }

    function it_returns_its_password()
    {
        $this->getPassword()->shouldBeLike(new Password(self::PASSWORD));
    }
}
