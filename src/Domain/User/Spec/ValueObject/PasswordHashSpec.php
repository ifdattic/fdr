<?php

namespace Spec\Domain\User\ValueObject;

use Domain\Core\Exception\AssertionFailedException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PasswordHashSpec extends ObjectBehavior
{
    const INVALID_LENGTH_HASH = '$2y$14$2RfLwLL./bzTyfNdBRaote';
    const VALID_HASH          = '$2y$14$2RfLwLL./bzTyfNdBRaotelrsmoOR61yUcDTOIDT84VwvvvZA7zJW';

    function it_throws_an_exception_on_empty_value()
    {
        $this
            ->shouldThrow(AssertionFailedException::CLASS)
            ->during('__construct', [''])
        ;
    }

    function it_throws_an_exception_on_false()
    {
        $this
            ->shouldThrow(AssertionFailedException::CLASS)
            ->during('__construct', [false])
        ;
    }

    function it_throws_an_exception_on_incorrect_length()
    {
        $this
            ->shouldThrow(AssertionFailedException::CLASS)
            ->during('__construct', [self::INVALID_LENGTH_HASH])
        ;
    }

    function it_throws_an_exception_if_value_not_a_string()
    {
        $this
            ->shouldThrow(AssertionFailedException::CLASS)
            ->during('__construct', [1234567890])
        ;
    }

    function it_returns_its_value()
    {
        $this->beConstructedWith(self::VALID_HASH);

        $this->getValue()->shouldReturn(self::VALID_HASH);
    }
}
