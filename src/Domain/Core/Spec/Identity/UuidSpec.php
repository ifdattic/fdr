<?php

namespace Spec\Domain\Core\Identity;

use Domain\Core\Exception\AssertionFailed;
use Domain\Core\Identity\Uuid;
use Domain\Core\Spec\TestValues;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Rhumsaa\Uuid\Uuid as RUuid;

class UuidSpec extends ObjectBehavior
{
    function it_throws_an_exception_if_value_is_not_uuid()
    {
        $this
            ->shouldThrow(AssertionFailed::CLASS)
            ->during('__construct', [TestValues::INVALID_UUID])
        ;
    }

    function it_returns_its_value()
    {
        $this->beConstructedWith(TestValues::UUID);

        $this->getValue()->shouldReturn(TestValues::UUID);
    }

    function it_generates_an_uuid()
    {
        $this->beConstructedThrough('generate');

        $this->shouldHaveType(Uuid::CLASS);
    }
}
