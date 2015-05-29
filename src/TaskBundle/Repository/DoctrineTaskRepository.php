<?php

namespace TaskBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Domain\Task\Repository\TaskRepository;

class DoctrineTaskRepository extends EntityRepository implements TaskRepository
{
    /** {@inheritdoc} */
    public function clear()
    {
        return $this->createQueryBuilder('t')
            ->delete()
            ->getQuery()
            ->execute()
        ;
    }
}
