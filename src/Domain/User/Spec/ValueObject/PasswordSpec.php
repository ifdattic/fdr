<?php

namespace Spec\Domain\User\ValueObject;

use Domain\Core\Exception\AssertionFailedException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PasswordSpec extends ObjectBehavior
{
    const INVALID_NON_STRING_PASSWORD = 1234567890;
    const TOO_SHORT_PASSWORD          = 'short';
    const VALID_PASSWORD              = '9wt24yk^T&ObwHDQ2bbDej3kZ^Llz@';

    function it_throws_an_exception_on_empty_value()
    {
        $this
            ->shouldThrow(AssertionFailedException::CLASS)
            ->during('__construct', [''])
        ;
    }

    function it_throws_an_exception_on_short_value()
    {
        $this
            ->shouldThrow(AssertionFailedException::CLASS)
            ->during('__construct', [self::TOO_SHORT_PASSWORD])
        ;
    }

    function it_throws_an_exception_on_long_value()
    {
        $tooLongPassword = str_repeat('i', 80);

        $this
            ->shouldThrow(AssertionFailedException::CLASS)
            ->during('__construct', [$tooLongPassword])
        ;
    }

    function it_throws_an_exception_if_value_not_a_string()
    {
        $this
            ->shouldThrow(AssertionFailedException::CLASS)
            ->during('__construct', [self::INVALID_NON_STRING_PASSWORD])
        ;
    }

    function it_returns_its_value()
    {
        $this->beConstructedWith(self::VALID_PASSWORD);

        $this->getValue()->shouldReturn(self::VALID_PASSWORD);
    }
}
