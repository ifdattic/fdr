<?php

namespace Spec\Domain\Task\Event;

use Domain\Task\Event\TaskWasEntered;
use Domain\Task\ValueObject\TaskId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TaskWasEnteredSpec extends ObjectBehavior
{
    const UUID = '5399dbab-ccd0-493c-be1a-67300de1671f';

    function let()
    {
        $this->beConstructedWith(TaskId::createFromString(self::UUID));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(TaskWasEntered::CLASS);
    }

    function it_should_return_task_id()
    {
        $this->getTaskId()->shouldHaveType(TaskId::CLASS);
    }
}
