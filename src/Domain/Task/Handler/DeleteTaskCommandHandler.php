<?php

namespace Domain\Task\Handler;

use Domain\Task\Command\DeleteTask;
use Domain\Task\Repository\TaskRepository;

class DeleteTaskCommandHandler
{
    /** @var TaskRepository */
    private $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function handle(DeleteTask $command)
    {
        $taskId = $command->getTaskId();

        $this->taskRepository->deleteByTaskId($taskId);
    }
}
