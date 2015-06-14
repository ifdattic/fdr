<?php

namespace Domain\Task\Event;

use Domain\Task\ValueObject\TaskId;

class TaskWasEntered
{
    /** @var TaskId */
    private $taskId;

    public function __construct(TaskId $taskId)
    {
        $this->taskId = $taskId;
    }

    /** @return TaskId */
    public function getTaskId()
    {
        return $this->taskId;
    }
}
