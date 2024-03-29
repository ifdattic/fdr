<?php

namespace Spec\Domain\Task\Handler;

use Domain\Core\Spec\TestValues;
use Domain\Core\Value\Description;
use Domain\Task\Command\CreateTask;
use Domain\Task\Entity\Task;
use Domain\Task\Handler\CreateTaskCommandHandler;
use Domain\Task\Repository\TaskRepository;
use Domain\Task\Value\Estimate;
use Domain\Task\Value\TaskName;
use Domain\Task\Value\TimeSpent;
use Domain\User\Entity\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CreateTaskCommandHandlerSpec extends ObjectBehavior
{
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
        $command->getName()->willReturn(new TaskName(TestValues::TASK_NAME));
        $command->getDate()->willReturn(new \DateTime(TestValues::DATE));
        $command->getDescription()->willReturn(new Description(TestValues::DESCRIPTION));
        $command->getEstimate()->willReturn(new Estimate(TestValues::ESTIMATE));
        $command->getCompletedAt()->willReturn(new \DateTime(TestValues::COMPLETED_DATE));
        $command->getTimeSpent()->willReturn(new TimeSpent(TestValues::TIME_SPENT));
        $command->getImportant()->willReturn(TestValues::NOT_IMPORTANT);
        $task = Argument::type(Task::CLASS);

        $taskRepository->add($task)->shouldBeCalled();
        $command->setTask($task)->shouldBeCalled();

        $this->handle($command);
    }
}
