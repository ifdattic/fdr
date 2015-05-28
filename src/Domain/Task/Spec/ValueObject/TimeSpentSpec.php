<?php

namespace Spec\Domain\Task\ValueObject;

use Domain\Core\Exception\AssertionFailedException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TimeSpentSpec extends ObjectBehavior
{
    const NUMBER = 4;

    function let()
    {
        $this->beConstructedWith(self::NUMBER);
    }

    function it_should_reject_string_value()
    {
        $this
            ->shouldThrow(AssertionFailedException::CLASS)
            ->during('__construct', ['4'])
        ;
    }

    function it_should_reject_float_value()
    {
        $this
            ->shouldThrow(AssertionFailedException::CLASS)
            ->during('__construct', [3.4])
        ;
    }

    function it_should_reject_negative_value()
    {
        $this
            ->shouldThrow(AssertionFailedException::CLASS)
            ->during('__construct', [-4])
        ;
    }

    function it_should_return_its_value()
    {
        $this->getValue()->shouldReturn(self::NUMBER);
    }

    function it_should_have_default_value()
    {
        $this->beConstructedWith();

        $this->getValue()->shouldReturn(0);
    }
}
