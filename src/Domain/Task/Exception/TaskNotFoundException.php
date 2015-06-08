<?php

namespace Domain\Task\Exception;

use Domain\Core\Exception\EntityNotFoundException;

class TaskNotFoundException extends EntityNotFoundException
{
    /** {@inheritdoc} */
    protected $message = 'Task not found';
}
