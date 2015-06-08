<?php

namespace TaskBundle\Repository;

use Domain\Task\Entity\Task;
use Domain\Task\Exception\TaskNotFoundException;
use Domain\Task\Repository\TaskRepository;
use Domain\Task\ValueObject\TaskId;

class InMemoryTaskRepository implements TaskRepository
{
    /** @var Domain\Task\Entity\Task[] */
    private $tasks = [];

    /** {@inheritdoc} */
    public function clear()
    {
        $this->tasks = [];
    }

    /** {@inheritdoc} */
    public function find($id)
    {
        $this->findByTaskId(new TaskId($id));
    }

    /** {@inheritdoc} */
    public function findByTaskId(TaskId $taskId)
    {
        foreach ($this->tasks as $task) {
            if ($taskId == $task->getId()) {
                return $task;
            }
        }

        throw new TaskNotFoundException();
    }

    /** {@inheritdoc} */
    public function add(Task $task)
    {
        $this->tasks[] = $task;
    }
}
