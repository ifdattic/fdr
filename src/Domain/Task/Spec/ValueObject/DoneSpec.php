<?php

namespace Spec\Domain\Task\ValueObject;

use Domain\Core\Exception\AssertionFailedException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DoneSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(true);
    }

    function it_should_reject_string_value()
    {
        $this
            ->shouldThrow(AssertionFailedException::CLASS)
            ->during('__construct', ['true'])
        ;
    }

    function it_should_reject_integer_value()
    {
        $this
            ->shouldThrow(AssertionFailedException::CLASS)
            ->during('__construct', [1])
        ;
    }

    function it_should_return_its_value()
    {
        $this->getValue()->shouldReturn(true);
    }

    function it_should_have_default_value()
    {
        $this->beConstructedWith();

        $this->getValue()->shouldReturn(false);
    }

    function it_should_return_default_value_when_constructed_with_null()
    {
        $this->beConstructedWith(null);

        $this->getValue()->shouldReturn(false);
    }
}
