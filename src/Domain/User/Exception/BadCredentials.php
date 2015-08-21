<?php

namespace Domain\User\Exception;

use Domain\Core\Exception\DomainException;

class BadCredentials extends DomainException
{
    /** @inheritdoc */
    protected $message = 'Bad credentials';

    /** @inheritdoc */
    protected $code = 401;
}
