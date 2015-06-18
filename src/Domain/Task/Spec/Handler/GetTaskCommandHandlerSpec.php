<?php

namespace Spec\Domain\Task\Handler;

use Domain\Task\Command\GetTask;
use Domain\Task\Entity\Task;
use Domain\Task\Handler\GetTaskCommandHandler;
use Domain\Task\Repository\TaskRepository;
use Domain\Task\ValueObject\TaskId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GetTaskCommandHandlerSpec extends ObjectBehavior
{
    const UUID = '5399dbab-ccd0-493c-be1a-67300de1671f';

    function let(TaskRepository $taskRepository)
    {
        $this->beConstructedWith($taskRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(GetTaskCommandHandler::CLASS);
    }

    function it_should_get_a_task(
        TaskRepository $taskRepository,
        Task $task,
        GetTask $command
    ) {
        $taskId = TaskId::createFromString(self::UUID);

        $taskRepository->findByTaskId($taskId)->shouldBeCalled()->willReturn($task);

        $command->setTask($task)->shouldBeCalled();
        $command->getTaskId()->shouldBeCalled()->willReturn($taskId);

        $this->handle($command);
    }
}
