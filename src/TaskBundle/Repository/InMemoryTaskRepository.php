<?php

namespace TaskBundle\Repository;

use Domain\Task\Entity\Task;
use Domain\Task\Exception\TaskNotFoundException;
use Domain\Task\Repository\TaskRepository;
use Domain\Task\ValueObject\TaskId;
use Domain\User\Entity\User;

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

    /** {@inheritdoc} */
    public function findAllByUser(User $user)
    {
        $tasks = [];

        foreach ($this->tasks as $task) {
            if ($user == $task->getUser()) {
                $tasks[] = $task;
            }
        }

        return $tasks;
    }

    /** {@inheritdoc} */
    public function removeByTaskId(TaskId $taskId)
    {
        $task = $this->findByTaskId($taskId);

        $this->remove($task);
    }

    /** {@inheritdoc} */
    public function remove(Task $task)
    {
        foreach ($this->tasks as $key => $existingTask) {
            if ($task->getId() == $existingTask->getId()) {
                unset($this->tasks[$key]);
            }
        }
    }

    /** @inheritdoc */
    public function save(Task $task)
    {
        foreach ($this->tasks as $key => $existingTask) {
            if ($task->getId() == $existingTask->getId()) {
                $this->tasks[$key] = $task;

                return;
            }
        }

        throw new TaskNotFoundException();
    }
}
