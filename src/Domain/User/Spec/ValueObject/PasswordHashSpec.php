<?php

namespace Spec\Domain\User\ValueObject;

use Domain\Core\Exception\AssertionFailedException;
use Domain\Core\Spec\TestValues;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PasswordHashSpec extends ObjectBehavior
{
    function it_throws_an_exception_on_empty_value()
    {
        $this
            ->shouldThrow(AssertionFailedException::CLASS)
            ->during('__construct', [''])
        ;
    }

    function it_throws_an_exception_on_false()
    {
        $this
            ->shouldThrow(AssertionFailedException::CLASS)
            ->during('__construct', [false])
        ;
    }

    function it_throws_an_exception_on_incorrect_length()
    {
        $this
            ->shouldThrow(AssertionFailedException::CLASS)
            ->during('__construct', [TestValues::INVALID_LENGTH_PASSWORD_HASH])
        ;
    }

    function it_throws_an_exception_if_value_not_a_string()
    {
        $this
            ->shouldThrow(AssertionFailedException::CLASS)
            ->during('__construct', [1234567890])
        ;
    }

    function it_returns_its_value()
    {
        $this->beConstructedWith(TestValues::PASSWORD_HASH);

        $this->getValue()->shouldReturn(TestValues::PASSWORD_HASH);
    }
}
