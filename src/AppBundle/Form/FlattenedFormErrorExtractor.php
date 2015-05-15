<?php

namespace AppBundle\Form;

use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;

final class FlattenedFormErrorExtractor implements FormErrorExtractorInterface
{
    /** {@inheritdocs} */
    public function extract(FormInterface $form)
    {
        $errors = [];

        /** @var FormError $error */
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors = array_merge($errors, $this->extract($child));
            }
        }

        return $errors;
    }
}
