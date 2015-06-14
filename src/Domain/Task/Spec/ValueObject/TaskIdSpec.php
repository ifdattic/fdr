<?php

namespace Spec\Domain\Task\ValueObject;

use Domain\Core\Exception\AssertionFailedException;
use Domain\Core\Identity\Uuid;
use Domain\Task\ValueObject\TaskId;
use PhpSpec\Exception\Example\ExampleException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TaskIdSpec extends ObjectBehavior
{
    const VALID_UUID = '5399dbab-ccd0-493c-be1a-67300de1671f';

    function let()
    {
        $uuid = new Uuid(self::VALID_UUID);

        $this->beConstructedWith($uuid);
    }

    function it_returns_its_value()
    {
        $this->getValue()->shouldReturn(self::VALID_UUID);
    }

    function it_creates_task_id_from_string()
    {
        $this->beConstructedThrough('createFromString', [self::VALID_UUID]);

        $this->shouldHaveType(TaskId::CLASS);

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

    function it_returns_its_value_on_string_usage()
    {
        $this->__toString()->shouldReturn(self::VALID_UUID);
    }
}
