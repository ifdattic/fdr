<?php

namespace Domain\Task\Command;

use Domain\User\Entity\User;

class GetTasksByUser
{
    /** @var \Domain\Task\Entity\Task[] */
    private $tasks;

    /** @var User */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /** @return User */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return Task[]
     * @throws \RuntimeException if tasks is not set
     */
    public function getTasks()
    {
        if (null === $this->tasks) {
            throw new \RuntimeException('Tasks not set');
        }

        return $this->tasks;
    }

    /** @param Task[] $tasks */
    public function setTasks(array $tasks)
    {
        $this->tasks = $tasks;
    }
}
