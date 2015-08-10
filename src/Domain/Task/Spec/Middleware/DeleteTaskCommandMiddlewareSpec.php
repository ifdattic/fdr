<?php

namespace Spec\Domain\Task\Middleware;

use Domain\Core\Spec\TestValues;
use Domain\Task\Command\CreateTask;
use Domain\Task\Command\DeleteTask;
use Domain\Task\Entity\Task;
use Domain\Task\Middleware\DeleteTaskCommandMiddleware;
use Domain\Task\Repository\TaskRepository;
use Domain\Task\ValueObject\TaskId;
use Domain\User\Entity\User;
use Domain\User\Exception\AccessDeniedException;
use Domain\User\Middleware\AuthMiddleware;
use Domain\User\Security\UserProvider;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DeleteTaskCommandMiddlewareSpec extends ObjectBehavior
{
    function let(UserProvider $userProvider, TaskRepository $taskRepository)
    {
        $this->beConstructedWith($userProvider, $taskRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DeleteTaskCommandMiddleware::CLASS);
        $this->shouldHaveType(AuthMiddleware::CLASS);
    }

    function it_should_skip_owner_check_if_command_not_owner_bound(CreateTask $command)
    {
        $callable = function () {};

        $this->handle($command, $callable);
    }

    function it_should_throw_an_exception_if_not_an_owner(
        UserProvider $userProvider,
        User $currentUser,
        User $user,
        TaskRepository $taskRepository,
        Task $task
    ) {
        $callable = function () {};
        $taskId = TaskId::createFromString(TestValues::UUID);
        $command = new DeleteTask($taskId);

        $userProvider->getUser()->shouldBeCalled()->willReturn($currentUser);
        $taskRepository->findByTaskId($taskId)->shouldBeCalled()->willReturn($task);
        $task->getUser()->shouldBeCalled()->willReturn($user);

        $this
            ->shouldThrow(AccessDeniedException::CLASS)
            ->during('handle', [$command, $callable])
        ;
    }

    function it_should_not_throw_an_exception_if_an_owner(
        UserProvider $userProvider,
        User $user,
        TaskRepository $taskRepository,
        Task $task
    ) {
        $callable = function () {};
        $taskId = TaskId::createFromString(TestValues::UUID);
        $command = new DeleteTask($taskId);

        $userProvider->getUser()->shouldBeCalled()->willReturn($user);
        $taskRepository->findByTaskId($taskId)->shouldBeCalled()->willReturn($task);
        $task->getUser()->shouldBeCalled()->willReturn($user);

        $this->handle($command, $callable);
    }
}
