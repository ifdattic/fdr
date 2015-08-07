<?php

namespace Spec\Domain\Task\Handler;

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
    const COMPLETED_DATE2 = '2015-06-15 17:34:55';
    const DATE2           = '2015-06-15';
    const DESCRIPTION2    = 'Alternative description';
    const ESTIMATED2      = 2;
    const IMPORTANT2      = true;
    const TASK_NAME2      = 'Alternative Task Name';
    const TIME_SPENT2     = 22;
    const UUID            = '5399dbab-ccd0-493c-be1a-67300de1671f';

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
        $taskId = TaskId::createFromString(self::UUID);
        $command->getId()->willReturn($taskId);
        $command->getName()->willReturn(new TaskName(self::TASK_NAME2));
        $command->getDate()->willReturn(new \DateTime(self::DATE2));
        $command->getDescription()->willReturn(new Description(self::DESCRIPTION2));
        $command->getEstimated()->willReturn(new Estimated(self::ESTIMATED2));
        $command->getCompletedAt()->willReturn(new \DateTime(self::COMPLETED_DATE2));
        $command->getTimeSpent()->willReturn(new TimeSpent(self::TIME_SPENT2));
        $command->getImportant()->willReturn(self::IMPORTANT2);
        $task = new Task(
            $taskId,
            $user->getWrappedObject(),
            new TaskName(self::TASK_NAME2),
            new \DateTime(self::COMPLETED_DATE2)
        );

        $taskRepository->findByTaskId($taskId)->willReturn($task)->shouldBeCalled();
        $taskRepository->save($task)->shouldBeCalled();

        $this->handle($command);
    }
}
