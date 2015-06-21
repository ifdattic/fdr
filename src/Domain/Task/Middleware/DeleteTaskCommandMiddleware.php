<?php

namespace Domain\Task\Middleware;

use Domain\Task\Command\DeleteTask;
use Domain\Task\Repository\TaskRepository;
use Domain\User\Middleware\AuthMiddleware;
use Domain\User\Security\UserProvider;

class DeleteTaskCommandMiddleware extends AuthMiddleware
{
    /** @var TaskRepository */
    private $taskRepository;

    public function __construct(UserProvider $userProvider, TaskRepository $taskRepository)
    {
        parent::__construct($userProvider);

        $this->taskRepository = $taskRepository;
    }

    /** {@inheritdoc} */
    protected function beforeHandle($command)
    {
        $task = $this->taskRepository->findByTaskId($command->getTaskId());

        if ($task->getUser() !== $this->getUser()) {
            $this->denyAccess();
        }
    }

    /** {@inheritdoc} */
    protected function applies($command)
    {
        return get_class($command) === DeleteTask::CLASS;
    }
}
