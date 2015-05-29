<?php

namespace TaskBundle\Repository;

use Domain\Task\Repository\TaskRepository;

class InMemoryTaskRepository implements TaskRepository
{
    /** @var Domain\Task\Entity\Task[] */
    private $tasks = [];

    /** {@inheritdoc} */
    public function clear()
    {
        $this->tasks = [];
    }
}
