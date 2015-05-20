<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Domain\User\Entity\User;
use Domain\User\Exception\UserNotFoundException;
use Domain\User\Repository\UserRepository;
use Domain\User\ValueObject\Email;
use Domain\User\ValueObject\UserId;

class DoctrineUserRepository extends EntityRepository implements UserRepository
{
    /** {@inheritdoc} */
    public function clear()
    {
        return $this->createQueryBuilder('u')
            ->delete()
            ->getQuery()
            ->execute()
        ;
    }

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

    /** {@inheritdoc} */
    public function isEmailUnique(Email $email)
    {
        $qb = $this->createQueryBuilder('u');

        $count = (int) $qb
            ->select($qb->expr()->count('u'))
            ->where('u.email.value = :email')
            ->setParameter('email', $email->getValue())
            ->getQuery()
            ->getSingleScalarResult()
        ;

        return 0 === $count;
    }
}
