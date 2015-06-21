<?php

namespace Domain\Task\Command;

use Domain\Task\ValueObject\TaskId;

class DeleteTask
{
    /** @var string */
    private $taskId;

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
}
