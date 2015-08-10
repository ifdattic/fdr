<?php

namespace Domain\Task\Handler;

use Domain\Core\Identity\Uuid;
use Domain\Task\Command\CreateTask;
use Domain\Task\Entity\Task;
use Domain\Task\Repository\TaskRepository;
use Domain\Task\ValueObject\TaskId;

class CreateTaskCommandHandler
{
    /** @var TaskRepository */
    private $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function handle(CreateTask $command)
    {
        $task = new Task(
            new TaskId(Uuid::generate()),
            $command->getUser(),
            $command->getName(),
            $command->getDate()
        );

        $task->setDescription($command->getDescription());
        $task->setEstimate($command->getEstimate());
        $task->setCompletedAt($command->getCompletedAt());
        $task->setTimeSpent($command->getTimeSpent());
        $task->setImportant($command->getImportant());

        $this->taskRepository->add($task);

        $command->setTask($task);
    }
}
