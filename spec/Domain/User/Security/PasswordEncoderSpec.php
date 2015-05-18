<?php

namespace spec\Domain\User\Security;

use Domain\Core\Exception\AssertionFailedException;
use Domain\User\ValueObject\Password;
use Domain\User\ValueObject\PasswordHash;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PasswordEncoderSpec extends ObjectBehavior
{
    const COST           = 4;
    const COST_ABOVE     = 32;
    const COST_BELOW     = 1;
    const VALID_PASSWORD = '9wt24yk^T&ObwHDQ2bbDej3kZ^Llz@';

    function let()
    {
        $this->beConstructedWith(self::COST);
    }

    function it_throws_an_exception_if_cost_is_below_range()
    {
        $this
            ->shouldThrow(\InvalidArgumentException::CLASS)
            ->during('__construct', [self::COST_BELOW])
        ;
    }

    function it_throws_an_exception_if_cost_is_above_range()
    {
        $this
            ->shouldThrow(\InvalidArgumentException::CLASS)
            ->during('__construct', [self::COST_ABOVE])
        ;
    }

    function it_encodes_a_password()
    {
        $password = new Password(self::VALID_PASSWORD);

        $this->encodePassword($password)->shouldHaveType(PasswordHash::CLASS);
    }
}
