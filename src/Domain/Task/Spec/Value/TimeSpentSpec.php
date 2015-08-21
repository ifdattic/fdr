<?php

namespace Spec\Domain\Task\Value;

use Domain\Core\Exception\AssertionFailed;
use Domain\Core\Spec\TestValues;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TimeSpentSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(TestValues::TIME_SPENT);
    }

    function it_should_reject_string_value()
    {
        $this
            ->shouldThrow(AssertionFailed::CLASS)
            ->during('__construct', ['4'])
        ;
    }

    function it_should_reject_float_value()
    {
        $this
            ->shouldThrow(AssertionFailed::CLASS)
            ->during('__construct', [3.4])
        ;
    }

    function it_should_reject_negative_value()
    {
        $this
            ->shouldThrow(AssertionFailed::CLASS)
            ->during('__construct', [-4])
        ;
    }

    function it_should_return_its_value()
    {
        $this->getValue()->shouldReturn(TestValues::TIME_SPENT);
    }

    function it_should_have_default_value()
    {
        $this->beConstructedWith();

        $this->getValue()->shouldReturn(0);
    }

    function it_should_return_default_value_when_constructed_with_null()
    {
        $this->beConstructedWith(null);

        $this->getValue()->shouldReturn(0);
    }
}
