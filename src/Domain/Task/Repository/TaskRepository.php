<?php

namespace Domain\Task\Repository;

use Domain\Task\Entity\Task;
use Domain\Task\Value\TaskId;
use Domain\User\Entity\User;

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

    /**
     * Find all tasks by user.
     *
     * @param  User   $user
     * @return Task[]
     */
    public function findAllByUser(User $user);

    /**
     * Remove task by id.
     *
     * @param  TaskId $taskId
     * @throws Domain\Task\Exception\TaskNotFoundException if task is not found.
     */
    public function removeByTaskId(TaskId $taskId);

    /**
     * Remove a task.
     *
     * @param  Task   $task
     */
    public function remove(Task $task);

    /**
     * Save task.
     *
     * @param  Task   $task
     * @throws Domain\Task\Exception\TaskNotFoundException if task is not found.
     */
    public function save(Task $task);
}
