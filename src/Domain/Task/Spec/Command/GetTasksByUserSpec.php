<?php

namespace Spec\Domain\Task\Command;

use Domain\Task\Command\GetTasksByUser;
use Domain\Task\Entity\Task;
use Domain\User\Entity\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GetTasksByUserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(GetTasksByUser::CLASS);
    }

    function let(User $user)
    {
        $this->beConstructedWith($user);
    }

    function it_should_return_its_user(User $user)
    {
        $this->getUser()->shouldBeLike($user);
    }

    function it_should_thrown_an_exception_if_returning_tasks_without_setting_them()
    {
        $this
            ->shouldThrow(\RuntimeException::CLASS)
            ->during('getTasks')
        ;
    }

    function it_should_return_tasks_which_was_set(Task $task1, Task $task2)
    {
        $tasks = [$task1, $task2];

        $this->setTasks($tasks);

        $this->getTasks()->shouldReturn($tasks);
    }
}
