<?php

namespace Domain\Core\Validation;

interface Validator
{
    /**
     * Validate a value.
     *
     * @param  mixed $value
     * @return array
     */
    public function validate($value);
}
