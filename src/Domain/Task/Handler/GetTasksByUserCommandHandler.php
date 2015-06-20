<?php

namespace Domain\Task\Handler;

use Domain\Task\Command\GetTasksByUser;
use Domain\Task\Repository\TaskRepository;

class GetTasksByUserCommandHandler
{
    /** @var TaskRepository */
    private $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function handle(GetTasksByUser $command)
    {
        $user = $command->getUser();
        $tasks = $this->taskRepository->findAllByUser($user);

        $command->setTasks($tasks);
    }
}
