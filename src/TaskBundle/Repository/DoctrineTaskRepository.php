<?php

namespace TaskBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Domain\Task\Entity\Task;
use Domain\Task\Exception\TaskNotFoundException;
use Domain\Task\Repository\TaskRepository;
use Domain\Task\Value\TaskId;
use Domain\User\Entity\User;

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

    /** {@inheritdoc} */
    public function findAllByUser(User $user)
    {
        $tasks = $this->createQueryBuilder('t')
            ->where('t.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->execute()
        ;

        return $tasks;
    }

    /** {@inheritdoc} */
    public function removeByTaskId(TaskId $taskId)
    {
        $task = $this->findByTaskId($taskId);

        $this->remove($task);
    }

    /** {@inheritdoc} */
    public function remove(Task $task)
    {
        $em = $this->getEntityManager();

        $em->remove($task);

        $em->flush();
    }

    /** @inheritdoc */
    public function save(Task $task)
    {
        $em = $this->getEntityManager();

        $em->flush();
    }
}
