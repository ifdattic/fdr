<?php

namespace Spec\Domain\Task\Handler;

use Domain\Task\Command\GetTasksByUser;
use Domain\Task\Entity\Task;
use Domain\Task\Handler\GetTasksByUserCommandHandler;
use Domain\Task\Repository\TaskRepository;
use Domain\User\Entity\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GetTasksByUserCommandHandlerSpec extends ObjectBehavior
{
    function let(TaskRepository $taskRepository)
    {
        $this->beConstructedWith($taskRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(GetTasksByUserCommandHandler::CLASS);
    }

    function it_should_get_user_tasks(
        TaskRepository $taskRepository,
        User $user,
        Task $task1,
        Task $task2,
        GetTasksByUser $command
    ) {
        $tasks = [$task1, $task2];

        $taskRepository->findAllByUser($user)->shouldBeCalled()->willReturn($tasks);

        $command->setTasks($tasks)->shouldBeCalled();
        $command->getUser()->shouldBeCalled()->willReturn($user);

        $this->handle($command);
    }
}
