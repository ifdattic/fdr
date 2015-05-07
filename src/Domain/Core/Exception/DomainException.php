<?php

namespace Domain\Core\Exception;

class DomainException extends \DomainException
{
    public function __construct($message = 'Domain failed', $code = 400, \Exception $previous = null)
    {
        parent::__construct($message, 400, $previous);
    }
}
