<?php

namespace AppBundle\Form\Type;

use Domain\User\Command\SignUp;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SignUpCommandType extends AbstractType
{
    /** {@inheritdoc} */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $notMapped = ['mapped' => false];

        $builder
            ->add('email', null, $notMapped)
            ->add('full_name', null, $notMapped)
            ->add('password', null, $notMapped)
        ;
    }

    /** {@inheritdoc} */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'validation_groups' => false,
            'empty_data' => function (FormInterface $form) {
                return new SignUp(
                    $form->get('email')->getData(),
                    $form->get('full_name')->getData(),
                    $form->get('password')->getData()
                );
            }
        ]);
    }

    /** {@inheritdoc} */
    public function getName()
    {
        return 'sign_up';
    }
}
