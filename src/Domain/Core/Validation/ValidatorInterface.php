<?php

namespace Domain\Core\Validation;

interface ValidatorInterface
{
    /**
     * Validate a value.
     *
     * @param  mixed $value
     * @return array
     */
    public function validate($value);
}
