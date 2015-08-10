<?php

namespace Spec\Domain\User\ValueObject;

use Domain\Core\Exception\AssertionFailedException;
use Domain\Core\Spec\TestValues;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FullNameSpec extends ObjectBehavior
{
    function it_throws_an_exception_on_empty_value()
    {
        $this
            ->shouldThrow(AssertionFailedException::CLASS)
            ->during('__construct', [''])
        ;
    }

    function it_returns_its_value()
    {
        $this->beConstructedWith(TestValues::FULLNAME);

        $this->getValue()->shouldReturn(TestValues::FULLNAME);
    }
}
