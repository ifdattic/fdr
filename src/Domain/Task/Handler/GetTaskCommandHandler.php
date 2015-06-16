<?php

namespace Domain\Task\Handler;

use Domain\Task\Command\GetTask;
use Domain\Task\Repository\TaskRepository;

class GetTaskCommandHandler
{
    /** @var TaskRepository */
    private $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function handle(GetTask $command)
    {
        $taskId = $command->getTaskId();
        $task = $this->taskRepository->findByTaskId($taskId);

        $command->setTask($task);
    }
}
