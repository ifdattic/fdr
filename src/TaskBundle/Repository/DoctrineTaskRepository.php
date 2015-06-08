<?php

namespace TaskBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Domain\Task\Entity\Task;
use Domain\Task\Exception\TaskNotFoundException;
use Domain\Task\Repository\TaskRepository;
use Domain\Task\ValueObject\TaskId;

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

    /** {@inheritdoc} */
    public function find($id)
    {
        $this->findByTaskId(new TaskId($id));
    }

    /** {@inheritdoc} */
    public function findByTaskId(TaskId $taskId)
    {
        $task = $this->createQueryBuilder('t')
            ->where('t.id = :id')
            ->setParameter('id', $taskId->getValue())
            ->getQuery()
            ->getOneOrNullResult()
        ;

        if (null === $task) {
            throw new TaskNotFoundException();
        }

        return $task;
    }

    /** {@inheritdoc} */
    public function add(Task $task)
    {
        $em = $this->getEntityManager();

        $em->persist($task);

        $em->flush();
    }
}
