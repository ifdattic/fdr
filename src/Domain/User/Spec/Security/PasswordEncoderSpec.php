<?php

namespace Spec\Domain\User\Security;

use Domain\Core\Exception\AssertionFailedException;
use Domain\Core\Spec\TestValues;
use Domain\User\ValueObject\Password;
use Domain\User\ValueObject\PasswordHash;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PasswordEncoderSpec extends ObjectBehavior
{
    const COST           = 4;
    const COST_ABOVE     = 32;
    const COST_BELOW     = 1;

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
        $password = new Password(TestValues::PASSWORD);

        $this->encodePassword($password)->shouldHaveType(PasswordHash::CLASS);
    }
}
