<?php

namespace Domain\User\Exception;

use Domain\Core\Exception\DomainException;

class AccessDeniedException extends DomainException
{
    public function __construct($message = 'Access Denied', \Exception $previous = null)
    {
        parrent::__construct($message, 403, $previous);
    }
}
