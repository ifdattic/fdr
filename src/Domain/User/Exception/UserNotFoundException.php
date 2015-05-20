<?php

namespace Domain\User\Exception;

use Domain\Core\Exception\EntityNotFoundException;

class UserNotFoundException extends EntityNotFoundException
{
    /** {@inheritdoc} */
    protected $message = 'User not found';
}
