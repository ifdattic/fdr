<?php

namespace Domain\Task\Command;

use Domain\Task\Entity\Task;
use Domain\Task\Value\TaskId;
use Domain\User\Middleware\OwnerBound;

class GetTask implements OwnerBound
{
    /** @var string */
    private $taskId;

    /** @var Task */
    private $task;

    /** @param string $taskId */
    public function __construct($taskId)
    {
        $this->taskId = $taskId;
    }

    /** @return TaskId */
    public function getTaskId()
    {
        return TaskId::createFromString($this->taskId);
    }

    /**
     * @return Task
     * @throws \RuntimeException if task is not set
     */
    public function getTask()
    {
        if (null === $this->task) {
            throw new \RuntimeException('Task not set');
        }

        return $this->task;
    }

    public function setTask(Task $task)
    {
        $this->task = $task;
    }

    /** {@inheritdoc} */
    public function getUser()
    {
        return $this->getTask()->getUser();
    }
}
