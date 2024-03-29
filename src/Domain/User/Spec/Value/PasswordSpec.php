<?php

namespace Spec\Domain\User\Value;

use Domain\Core\Exception\AssertionFailed;
use Domain\Core\Spec\TestValues;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PasswordSpec extends ObjectBehavior
{
    function it_throws_an_exception_on_empty_value()
    {
        $this
            ->shouldThrow(AssertionFailed::CLASS)
            ->during('__construct', [''])
        ;
    }

    function it_throws_an_exception_on_short_value()
    {
        $this
            ->shouldThrow(AssertionFailed::CLASS)
            ->during('__construct', [TestValues::TOO_SHORT_PASSWORD])
        ;
    }

    function it_throws_an_exception_on_long_value()
    {
        $tooLongPassword = str_repeat('i', 80);

        $this
            ->shouldThrow(AssertionFailed::CLASS)
            ->during('__construct', [$tooLongPassword])
        ;
    }

    function it_throws_an_exception_if_value_not_a_string()
    {
        $this
            ->shouldThrow(AssertionFailed::CLASS)
            ->during('__construct', [TestValues::INVALID_NON_STRING_PASSWORD])
        ;
    }

    function it_returns_its_value()
    {
        $this->beConstructedWith(TestValues::PASSWORD);

        $this->getValue()->shouldReturn(TestValues::PASSWORD);
    }
}
