<?php

namespace AppBundle\Validation\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueFieldValidator extends ConstraintValidator
{
    /** @param object $repository */
    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    /** {@inheritdoc} */
    public function validate($value, Constraint $constraint)
    {
        $valueObject = new $constraint->valueClass($value);
        $isUnique = $this->repository->{$constraint->repositoryMethod}($valueObject);

        if (false === $isUnique) {
            $this->context->buildViolation($constraint->message)
                ->addViolation()
            ;
        }
    }
}
