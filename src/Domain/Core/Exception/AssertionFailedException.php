<?php

namespace Domain\Core\Exception;

class AssertionFailedException extends DomainException
{
    public function __construct($message = 'Assertion failed', $code = 400, \Exception $previous = null)
    {
        parent::__construct($message, 400, $previous);
    }
}
