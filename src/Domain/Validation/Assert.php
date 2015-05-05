<?php

namespace Domain\Validation;

use Assert\Assertion as BaseAssertion;

class Assert extends BaseAssertion
{
    protected static $exceptionClass = 'Domain\Validation\AssertionFailedException';
}
