<?php

namespace Domain\Core\Validation;

class Error
{
    /** @var string */
    private $message;

    /** @var string */
    private $field;

    /** @var int */
    private $code;

    /**
     * @param string $message Error message
     * @param string $field   The field of the invalid value
     * @param int    $code    Error code
     */
    public function __construct($message, $field = null, $code = null)
    {
        Assert::string($message, 'Error message must be a string.');
        Assert::nullOrString($field, 'Error field must be a string.');
        Assert::nullOrInteger($code, 'Error code must be an integer.');

        $this->message = $message;
        $this->field = $field;
        $this->code = $code;
    }

    /** @return string */
    public function getMessage()
    {
        return $this->message;
    }

    /** @return string */
    public function getField()
    {
        return $this->field;
    }

    /** @return int */
    public function getCode()
    {
        return $this->code;
    }

    /** @return string */
    public function __toString()
    {
        return $this->message;
    }
}
