<?php

namespace spec\Domain\User\Command;

use Domain\Core\Exception\AssertionFailedException;
use Domain\User\ValueObject\Email;
use Domain\User\ValueObject\FullName;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SignUpSpec extends ObjectBehavior
{
    const EMAIL    = 'virgil@mundell.com';
    const FULLNAME = 'Virgil Mundell';

    function let()
    {
        $this->beConstructedWith(self::EMAIL, self::FULLNAME);
    }

    function it_throws_an_exception_if_invalid_value_is_given()
    {
        $this
            ->shouldThrow(AssertionFailedException::CLASS)
            ->during('__construct', ['invalid', self::FULLNAME])
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
}
