<?php

namespace Spec\Domain\Task\Handler;

use Domain\Task\Command\DeleteTask;
use Domain\Task\Handler\DeleteTaskCommandHandler;
use Domain\Task\Repository\TaskRepository;
use Domain\Task\ValueObject\TaskId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DeleteTaskCommandHandlerSpec extends ObjectBehavior
{
    const UUID = '5399dbab-ccd0-493c-be1a-67300de1671f';

    function let(TaskRepository $taskRepository)
    {
        $this->beConstructedWith($taskRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DeleteTaskCommandHandler::CLASS);
    }

    function it_should_delete_a_task(
        TaskRepository $taskRepository,
        DeleteTask $command
    ) {
        $taskId = TaskId::createFromString(self::UUID);

        $taskRepository->removeByTaskId($taskId)->shouldBeCalled();

        $command->getTaskId()->shouldBeCalled()->willReturn($taskId);

        $this->handle($command);
    }
}
