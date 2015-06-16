<?php

namespace Domain\User\Exception;

use Domain\Core\Exception\DomainException;

class AccessDeniedException extends DomainException
{
    public function __construct($message = 'Access Denied', \Exception $previous = null)
    {
        parent::__construct($message, 403, $previous);
    }
}
