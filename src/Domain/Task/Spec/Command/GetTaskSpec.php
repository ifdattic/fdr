<?php

namespace Spec\Domain\Task\Command;

use Domain\Core\Spec\TestValues;
use Domain\Task\Command\GetTask;
use Domain\Task\Entity\Task;
use Domain\Task\ValueObject\TaskId;
use Domain\User\Entity\User;
use Domain\User\Middleware\OwnerBound;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GetTaskSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(OwnerBound::CLASS);
        $this->shouldHaveType(GetTask::CLASS);
    }

    function let()
    {
        $this->beConstructedWith(TestValues::UUID);
    }

    function it_should_return_its_task_id()
    {
        $this->getTaskId()->shouldBeLike(TaskId::createFromString(TestValues::UUID));
    }

    function it_should_throw_an_exception_if_returning_task_without_setting_it()
    {
        $this
            ->shouldThrow(\RuntimeException::CLASS)
            ->during('getTask')
        ;
    }

    function it_should_return_a_task_which_was_set(Task $task)
    {
        $this->setTask($task);

        $this->getTask()->shouldReturn($task);
    }

    function it_should_throw_an_exception_if_returning_user_without_task_set()
    {
        $this
            ->shouldThrow(\RuntimeException::CLASS)
            ->during('getUser')
        ;
    }

    function it_should_return_a_task_user(Task $task, User $user)
    {
        $task->getUser()->shouldBeCalled()->willReturn($user);

        $this->setTask($task);

        $this->getUser()->shouldReturn($user);
    }
}
