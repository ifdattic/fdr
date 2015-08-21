<?php

namespace Spec\Domain\Task\Value;

use Domain\Core\Exception\AssertionFailed;
use Domain\Core\Spec\TestValues;
use Domain\Task\Value\Estimate;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EstimateSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(TestValues::ESTIMATE);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Estimate::CLASS);
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
        $this->getValue()->shouldReturn(TestValues::ESTIMATE);
    }

    function it_should_have_default_value()
    {
        $this->beConstructedWith();

        $this->getValue()->shouldReturn(1);
    }

    function it_should_return_default_value_when_constructed_with_null()
    {
        $this->beConstructedWith(null);

        $this->getValue()->shouldReturn(1);
    }
}
