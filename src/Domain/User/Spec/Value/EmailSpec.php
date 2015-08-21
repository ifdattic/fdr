<?php

namespace Spec\Domain\User\Value;

use Domain\Core\Exception\AssertionFailed;
use Domain\Core\Spec\TestValues;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EmailSpec extends ObjectBehavior
{
    function it_throws_an_exception_on_empty_value()
    {
        $this
            ->shouldThrow(AssertionFailed::CLASS)
            ->during('__construct', [''])
        ;
    }

    function it_throws_an_exception_on_invalid_email()
    {
        $this
            ->shouldThrow(AssertionFailed::CLASS)
            ->during('__construct', [TestValues::INVALID_EMAIL])
        ;
    }

    function it_returns_its_value()
    {
        $this->beConstructedWith(TestValues::EMAIL);

        $this->getValue()->shouldReturn(TestValues::EMAIL);
    }
}
