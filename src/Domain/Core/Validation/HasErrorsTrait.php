<?php

namespace Domain\Core\Validation;

trait HasErrorsTrait
{
    /** @var Error[] */
    private $errors;

    /** @param \Traversable|Error[] $errors */
    public function addErrors($errors)
    {
        Assert::isTraversable($errors, 'Errors must be traversable.');

        foreach ($errors as $error) {
            $this->addError($error);
        }
    }

    /** @param Error $error */
    public function addError(Error $error)
    {
        $this->errors[] = $error;
    }

    /** @return boolean */
    public function hasErrors()
    {
        return count($this->errors) > 0;
    }

    /** @return Error[] */
    public function getErrors()
    {
        return $this->errors;
    }
}
