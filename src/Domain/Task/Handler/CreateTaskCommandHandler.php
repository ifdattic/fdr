<?php

namespace Domain\Task\Handler;

use Domain\Core\Identity\Uuid;
use Domain\Task\Command\CreateTask;
use Domain\Task\Entity\Task;
use Domain\Task\Repository\TaskRepository;
use Domain\Task\Value\TaskId;

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

        $task->updateDescription($command->getDescription());
        $task->setInitialEstimate($command->getEstimate());
        is_null($command->getCompletedAt()) ? $task->markAsIncomplete() : $task->complete($command->getCompletedAt());
        $task->setInitialTimeSpent($command->getTimeSpent());
        $command->getImportant() ? $task->markAsImportant() : $task->markAsNotImportant();

        $this->taskRepository->add($task);

        $command->setTask($task);
    }
}
