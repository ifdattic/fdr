<?php

namespace AppBundle\Validation\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\MissingOptionsException;

/**
 * @Annotation
 */
class UniqueField extends Constraint
{
    /** @var string */
    public $message = 'This value should be unique.';

    /** @var string */
    public $repositoryMethod = null;

    /** @var string */
    public $service = 'validator.unique';

    /** @var string */
    public $valueObjectClass = null;

    /** {@inheritdoc} */
    public function __construct($options = null)
    {
        parent::__construct($options);

        if (null === $this->valueObjectClass) {
            throw new MissingOptionsException(
                sprintf('The class for the value object must be given for constraint %s', __CLASS__),
                ['valueObjectClass']
            );
        }

        if (null === $this->repositoryMethod) {
            throw new MissingOptionsException(
                sprintf('"repositoryMethod" must be given for constraint %s', __CLASS__),
                ['repositoryMethod']
            );
        }
    }

    /** {@inheritdoc} */
    public function validatedBy()
    {
        return $this->service;
    }
}
