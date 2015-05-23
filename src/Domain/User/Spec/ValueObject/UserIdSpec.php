<?php

namespace Spec\Domain\User\ValueObject;

use Domain\Core\Exception\AssertionFailedException;
use Domain\Core\Identity\Uuid;
use Domain\User\ValueObject\UserId;
use PhpSpec\Exception\Example\ExampleException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserIdSpec extends ObjectBehavior
{
    const VALID_UUID = '5399dbab-ccd0-493c-be1a-67300de1671f';

    function it_returns_its_value()
    {
        $uuid = new Uuid(self::VALID_UUID);

        $this->beConstructedWith($uuid);

        $this->getValue()->shouldReturn(self::VALID_UUID);
    }

    function it_creates_user_id_from_string()
    {
        $this->beConstructedThrough('createFromString', [self::VALID_UUID]);

        $this->shouldHaveType(UserId::CLASS);

        $this->getValue()->shouldReturn(self::VALID_UUID);
    }

    function it_should_reject_invalid_uuid_string()
    {
        $this->beConstructedThrough('createFromString', ['invalid']);

        try {
            $this->getWrappedObject();

            throw new ExampleException('Expected exception was not thrown');
        } catch (AssertionFailedException $e) {
        }
    }
}
