<?php

namespace spec\Domain\Core\Identity;

use Domain\Core\Exception\AssertionFailedException;
use Domain\Core\Identity\Uuid;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Rhumsaa\Uuid\Uuid as RUuid;

class UuidSpec extends ObjectBehavior
{
    const INVALID_UUID = '123';
    const VALID_UUID   = '5399dbab-ccd0-493c-be1a-67300de1671f';

    function it_throws_an_exception_if_value_is_not_uuid()
    {
        $this
            ->shouldThrow(AssertionFailedException::CLASS)
            ->during('__construct', [self::INVALID_UUID])
        ;
    }

    function it_returns_its_value()
    {
        $this->beConstructedWith(self::VALID_UUID);

        $this->getValue()->shouldReturn(self::VALID_UUID);
    }

    function it_generates_an_uuid()
    {
        $this->beConstructedThrough('generate');

        $this->shouldHaveType(Uuid::CLASS);
    }
}
