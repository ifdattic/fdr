<?php

namespace Spec\Domain\User\ValueObject;

use Domain\Core\Exception\AssertionFailedException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FullNameSpec extends ObjectBehavior
{
    const VALID_FULLNAME = 'Full Name';

    function it_throws_an_exception_on_empty_value()
    {
        $this
            ->shouldThrow(AssertionFailedException::CLASS)
            ->during('__construct', [''])
        ;
    }

    function it_returns_its_value()
    {
        $this->beConstructedWith(self::VALID_FULLNAME);

        $this->getValue()->shouldReturn(self::VALID_FULLNAME);
    }
}
