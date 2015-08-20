<?php

namespace Spec\Domain\Core\ValueObject;

use Domain\Core\Exception\AssertionFailed;
use Domain\Core\Spec\TestValues;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DescriptionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(TestValues::DESCRIPTION);
    }

    function it_returns_its_value()
    {
        $this->getValue()->shouldReturn(TestValues::DESCRIPTION);
    }

    function it_should_return_null_when_constructed_without_value()
    {
        $this->beConstructedWith();

        $this->getValue()->shouldReturn(null);
    }

    function it_should_return_null_when_constructed_with_null()
    {
        $this->beConstructedWith(null);

        $this->getValue()->shouldReturn(null);
    }

    function it_should_throw_an_exception_if_value_is_not_null_or_string()
    {
        $this
            ->shouldThrow(AssertionFailed::CLASS)
            ->during('__construct', [0])
        ;
    }
}
