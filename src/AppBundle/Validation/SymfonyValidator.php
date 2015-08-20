<?php

namespace AppBundle\Validation;

use Doctrine\Common\Inflector\Inflector;
use Domain\Core\Validation\Error;
use Domain\Core\Validation\Validator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SymfonyValidator implements Validator
{
    /** @var ValidatorInterface */
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /** {@inheritdoc} */
    public function validate($value)
    {
        $violations = $this->validator->validate($value);

        $errors = [];

        /** @var \Symfony\Component\Validator\ConstraintViolationListInterface $violation */
        foreach ($violations as $violation) {
            $errors[] = new Error(
                $violation->getMessage(),
                Inflector::tableize($violation->getPropertyPath()),
                $violation->getCode()
            );
        }

        return $errors;
    }
}
