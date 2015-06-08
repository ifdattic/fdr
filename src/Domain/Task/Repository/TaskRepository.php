<?php

namespace Domain\Task\Repository;

use Domain\Task\Entity\Task;
use Domain\Task\ValueObject\TaskId;

interface TaskRepository
{
    /**
     * Clear all tasks.
     *
     * @return void
     */
    public function clear();

    /**
     * Find task by id.
     *
     * @param  TaskId $taskId
     * @return Task
     * @throws Domain\Task\Exception\TaskNotFoundException if task is not found.
     */
    public function findByTaskId(TaskId $taskId);

    /**
     * Add a task.
     *
     * @param Task $task
     */
    public function add(Task $task);
}
