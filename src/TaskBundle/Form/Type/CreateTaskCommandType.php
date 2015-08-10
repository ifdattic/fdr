<?php

namespace TaskBundle\Form\Type;

use Domain\Task\Command\CreateTask;
use Domain\User\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateTaskCommandType extends AbstractType
{
    /** @var User */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /** {@inheritdoc} */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $notMapped = ['mapped' => false];

        $builder
            ->add('name', null, $notMapped)
            ->add('date', null, $notMapped)
            ->add('description', null, $notMapped)
            ->add('estimate', 'integer', $notMapped)
            ->add('completed_at', null, $notMapped)
            ->add('time_spent', 'integer', $notMapped)
            ->add('important', 'checkbox', $notMapped)
        ;
    }

    /** {@inheritdoc} */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'validation_groups' => false,
            'empty_data' => function (FormInterface $form) {
                return new CreateTask(
                    $this->user,
                    $form->get('name')->getData(),
                    $form->get('date')->getData(),
                    $form->get('description')->getData(),
                    $form->get('estimate')->getData(),
                    $form->get('completed_at')->getData(),
                    $form->get('time_spent')->getData(),
                    $form->get('important')->getData()
                );
            }
        ]);
    }

    /** {@inheritdoc} */
    public function getName()
    {
        return 'create_task';
    }
}
