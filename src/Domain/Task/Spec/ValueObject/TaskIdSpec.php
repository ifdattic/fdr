<?php

namespace Spec\Domain\Task\ValueObject;

use Domain\Core\Exception\AssertionFailedException;
use Domain\Core\Identity\Uuid;
use Domain\Core\Spec\TestValues;
use Domain\Task\ValueObject\TaskId;
use PhpSpec\Exception\Example\ExampleException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TaskIdSpec extends ObjectBehavior
{
    function let()
    {
        $uuid = new Uuid(TestValues::UUID);

        $this->beConstructedWith($uuid);
    }

    function it_returns_its_value()
    {
        $this->getValue()->shouldReturn(TestValues::UUID);
    }

    function it_creates_task_id_from_string()
    {
        $this->beConstructedThrough('createFromString', [TestValues::UUID]);

        $this->shouldHaveType(TaskId::CLASS);

        $this->getValue()->shouldReturn(TestValues::UUID);
    }

    function it_should_reject_invalid_uuid_string()
    {
        $this->beConstructedThrough('createFromString', [TestValues::INVALID_UUID]);

        try {
            $this->getWrappedObject();

            throw new ExampleException('Expected exception was not thrown');
        } catch (AssertionFailedException $e) {
        }
    }

    function it_returns_its_value_on_string_usage()
    {
        $this->__toString()->shouldReturn(TestValues::UUID);
    }
}
