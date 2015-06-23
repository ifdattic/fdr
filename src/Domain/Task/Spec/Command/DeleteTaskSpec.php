<?php

namespace Spec\Domain\Task\Command;

use Domain\Task\Command\DeleteTask;
use Domain\Task\ValueObject\TaskId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DeleteTaskSpec extends ObjectBehavior
{
    const UUID = '5399dbab-ccd0-493c-be1a-67300de1671f';

    function it_is_initializable()
    {
        $this->shouldHaveType(DeleteTask::CLASS);
    }

    function let()
    {
        $this->beConstructedWith(self::UUID);
    }

    function it_should_return_its_task_id()
    {
        $this->getTaskId()->shouldBeLike(TaskId::createFromString(self::UUID));
    }
}
