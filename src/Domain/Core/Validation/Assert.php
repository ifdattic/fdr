<?php

namespace Domain\Core\Validation;

use Assert\Assertion as BaseAssertion;
use Domain\Core\Exception\AssertionFailed;

class Assert extends BaseAssertion
{
    protected static $exceptionClass = AssertionFailed::CLASS;
}
