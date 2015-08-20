<?php

namespace Spec\Domain\User\ValueObject;

use Domain\Core\Exception\AssertionFailed;
use Domain\Core\Identity\Uuid;
use Domain\Core\Spec\TestValues;
use Domain\User\ValueObject\UserId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserIdSpec extends ObjectBehavior
{
    function it_returns_its_value()
    {
        $uuid = new Uuid(TestValues::UUID);

        $this->beConstructedWith($uuid);

        $this->getValue()->shouldReturn(TestValues::UUID);
    }

    function it_creates_user_id_from_string()
    {
        $this->beConstructedThrough('createFromString', [TestValues::UUID]);

        $this->shouldHaveType(UserId::CLASS);

        $this->getValue()->shouldReturn(TestValues::UUID);
    }

    function it_should_reject_invalid_uuid_string()
    {
        $this->beConstructedThrough('createFromString', [TestValues::INVALID_UUID]);

        $this->shouldThrow(AssertionFailed::CLASS)->duringInstantiation();
    }
}
