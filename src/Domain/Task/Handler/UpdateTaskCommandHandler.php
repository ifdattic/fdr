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
        $task = $this->taskRepository->findByTaskId($command->getId());

        $task->setName($command->getName());
        $task->setDate($command->getDate());
        $task->setDescription($command->getDescription());
        $task->setEstimated($command->getEstimated());
        $task->setCompletedAt($command->getCompletedAt());
        $task->setTimeSpent($command->getTimeSpent());
        $task->setImportant($command->getImportant());

        $this->taskRepository->save($task);
    }
}
