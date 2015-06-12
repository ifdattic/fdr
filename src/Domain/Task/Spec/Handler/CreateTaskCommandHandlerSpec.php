<?php

namespace Spec\Domain\Task\Handler;

use Domain\Core\ValueObject\Description;
use Domain\Task\Command\CreateTask;
use Domain\Task\Entity\Task;
use Domain\Task\Handler\CreateTaskCommandHandler;
use Domain\Task\Repository\TaskRepository;
use Domain\Task\ValueObject\Estimated;
use Domain\Task\ValueObject\TaskName;
use Domain\Task\ValueObject\TimeSpent;
use Domain\User\Entity\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CreateTaskCommandHandlerSpec extends ObjectBehavior
{
    const DATE           = '2015-04-15';
    const DESCRIPTION    = 'This is the description.';
    const COMPLETED_DATE = '2015-04-15 13:14:15';
    const ESTIMATED      = 3;
    const TASK_NAME      = 'Task Name';
    const TIME_SPENT     = 23;

    function let(TaskRepository $taskRepository)
    {
        $this->beConstructedWith($taskRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CreateTaskCommandHandler::CLASS);
    }

    function it_should_persist_valid_data(
        TaskRepository $taskRepository,
        User $user,
        CreateTask $command
    ) {
        $command->getUser()->willReturn($user);
        $command->getName()->willReturn(new TaskName(self::TASK_NAME));
        $command->getDate()->willReturn(new \DateTime(self::DATE));
        $command->getDescription()->willReturn(new Description(self::DESCRIPTION));
        $command->getEstimated()->willReturn(new Estimated(self::ESTIMATED));
        $command->getCompletedAt()->willReturn(new \DateTime(self::COMPLETED_DATE));
        $command->getTimeSpent()->willReturn(new TimeSpent(self::TIME_SPENT));
        $task = Argument::type(Task::CLASS);

        $taskRepository->add($task)->shouldBeCalled();
        $command->setTask($task)->shouldBeCalled();

        $this->handle($command);
    }
}
