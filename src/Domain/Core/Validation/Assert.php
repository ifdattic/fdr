<?php

namespace Domain\Core\Validation;

use Assert\Assertion as BaseAssertion;
use Domain\Core\Exception\AssertionFailedException;

class Assert extends BaseAssertion
{
    protected static $exceptionClass = AssertionFailedException::CLASS;
}
