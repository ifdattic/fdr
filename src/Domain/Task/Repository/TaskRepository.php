<?php

namespace Domain\Task\Repository;

interface TaskRepository
{
    /**
     * Clear all tasks.
     *
     * @return void
     */
    public function clear();
}
