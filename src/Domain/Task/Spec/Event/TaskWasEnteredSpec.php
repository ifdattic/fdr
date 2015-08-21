<?php

namespace Spec\Domain\Task\Event;

use Domain\Core\Spec\TestValues;
use Domain\Task\Event\TaskWasEntered;
use Domain\Task\Value\TaskId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TaskWasEnteredSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(TaskId::createFromString(TestValues::UUID));
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
