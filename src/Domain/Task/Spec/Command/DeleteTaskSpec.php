<?php

namespace Spec\Domain\Task\Command;

use Domain\Core\Spec\TestValues;
use Domain\Task\Command\DeleteTask;
use Domain\Task\Value\TaskId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DeleteTaskSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DeleteTask::CLASS);
    }

    function let()
    {
        $this->beConstructedWith(TestValues::UUID);
    }

    function it_should_return_its_task_id()
    {
        $this->getTaskId()->shouldBeLike(TaskId::createFromString(TestValues::UUID));
    }
}
