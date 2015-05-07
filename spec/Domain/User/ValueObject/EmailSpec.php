<?php

namespace spec\Domain\User\ValueObject;

use Domain\Core\Exception\AssertionFailedException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EmailSpec extends ObjectBehavior
{
    const INVALID_EMAIL = 'not valid';
    const VALID_EMAIL   = 'email@valid.com';

    function it_throws_an_exception_on_empty_value()
    {
        $this
            ->shouldThrow(AssertionFailedException::CLASS)
            ->during('__construct', [''])
        ;
    }

    function it_throws_an_exception_on_invalid_email()
    {
        $this
            ->shouldThrow(AssertionFailedException::CLASS)
            ->during('__construct', [self::INVALID_EMAIL])
        ;
    }

    function it_returns_its_value()
    {
        $this->beConstructedWith(self::VALID_EMAIL);

        $this->getValue()->shouldReturn(self::VALID_EMAIL);
    }
}
