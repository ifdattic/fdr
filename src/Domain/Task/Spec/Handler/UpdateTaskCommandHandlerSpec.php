<?php

namespace Spec\Domain\Task\Handler;

use Domain\Core\Spec\TestValues;
use Domain\Core\ValueObject\Description;
use Domain\Task\Command\UpdateTask;
use Domain\Task\Entity\Task;
use Domain\Task\Handler\UpdateTaskCommandHandler;
use Domain\Task\Repository\TaskRepository;
use Domain\Task\ValueObject\Estimated;
use Domain\Task\ValueObject\TaskId;
use Domain\Task\ValueObject\TaskName;
use Domain\Task\ValueObject\TimeSpent;
use Domain\User\Entity\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UpdateTaskCommandHandlerSpec extends ObjectBehavior
{
    function let(TaskRepository $taskRepository)
    {
        $this->beConstructedWith($taskRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UpdateTaskCommandHandler::CLASS);
    }

    function it_should_persist_valid_data(
        TaskRepository $taskRepository,
        User $user,
        UpdateTask $command
    ) {
        $taskId = TaskId::createFromString(TestValues::UUID);

        $command->getName()->willReturn(new TaskName(TestValues::TASK_NAME2));
        $command->getDate()->willReturn(new \DateTime(TestValues::DATE2));
        $command->getDescription()->willReturn(new Description(TestValues::DESCRIPTION2));
        $command->getEstimated()->willReturn(new Estimated(TestValues::ESTIMATED2));
        $command->getCompletedAt()->willReturn(new \DateTime(TestValues::COMPLETED_DATE2));
        $command->getTimeSpent()->willReturn(new TimeSpent(TestValues::TIME_SPENT2));
        $command->getImportant()->willReturn(TestValues::IMPORTANT);

        $task = new Task(
            $taskId,
            $user->getWrappedObject(),
            new TaskName(TestValues::TASK_NAME2),
            new \DateTime(TestValues::COMPLETED_DATE2)
        );
        $command->getTask()->willReturn($task);

        $taskRepository->save($task)->shouldBeCalled();

        $this->handle($command);
    }
}
