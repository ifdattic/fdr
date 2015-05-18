<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Domain\User\Entity\User;
use Domain\User\Exception\UserNotFoundException;
use Domain\User\Repository\UserRepository;
use Domain\User\ValueObject\UserId;

class DoctrineUserRepository extends EntityRepository implements UserRepository
{
    /** {@inheritdoc} */
    public function find($id)
    {
        $this->findByUserId(new UserId($id));
    }

    /** {@inheritdoc} */
    public function findByUserId(UserId $userId)
    {
    }

    /** {@inheritdoc} */
    public function findAll()
    {
    }

    /** {@inheritdoc} */
    public function add(User $user)
    {
        $em = $this->getEntityManager();

        $em->persist($user);

        $em->flush();
    }

    /** {@inheritdoc} */
    public function remove(User $user)
    {
    }
}
