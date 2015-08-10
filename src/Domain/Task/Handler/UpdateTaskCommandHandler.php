<?php

namespace Domain\Task\Handler;

use Domain\Task\Command\UpdateTask;
use Domain\Task\Repository\TaskRepository;

class UpdateTaskCommandHandler
{
    /** @var TaskRepository */
    private $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function handle(UpdateTask $command)
    {
        $task = $command->getTask();

        $task->updateName($command->getName());
        $task->updateDate($command->getDate());
        $task->updateDescription($command->getDescription());
        $task->adjustEstimate($command->getEstimate());
        is_null($command->getCompletedAt()) ? $task->markAsIncomplete() : $task->complete($command->getCompletedAt());
        $task->adjustTimeSpent($command->getTimeSpent());
        $command->getImportant() ? $task->markAsImportant() : $task->markAsNotImportant();

        $this->taskRepository->save($task);
    }
}
