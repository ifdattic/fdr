<?php

namespace Spec\TaskBundle\Repository;

use Domain\Core\ValueObject\Description;
use Domain\Task\Entity\Task;
use Domain\Task\Exception\TaskNotFoundException;
use Domain\Task\ValueObject\TaskId;
use Domain\Task\ValueObject\TaskName;
use Domain\User\Entity\User;
use Domain\User\ValueObject\Email;
use Domain\User\ValueObject\FullName;
use Domain\User\ValueObject\PasswordHash;
use Domain\User\ValueObject\UserId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TaskBundle\Repository\InMemoryTaskRepository;

class InMemoryTaskRepositorySpec extends ObjectBehavior
{
    const DATE          = '2015-04-15';
    const EMAIL         = 'virgil@mundell.com';
    const FULLNAME      = 'Virgil Mundell';
    const PASSWORD_HASH = '$2y$04$dWGqp58K1Xjr5tJUX/5TjOgWUBqC9EnPS8/sLog35cC46FJZh20QW';
    const TASK_NAME     = 'Task Name';
    const UUID          = '5399dbab-ccd0-493c-be1a-67300de1671f';

    /** @var Task */
    private $task;

    function let()
    {
        $user = new User(
            UserId::createFromString(self::UUID),
            new Email(self::EMAIL),
            new FullName(self::FULLNAME),
            new PasswordHash(self::PASSWORD_HASH)
        );

        $this->task = new Task(
            TaskId::createFromString(self::UUID),
            $user,
            new TaskName(self::TASK_NAME),
            new \DateTime(self::DATE)
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(InMemoryTaskRepository::CLASS);
    }

    function it_should_clear_all_tasks()
    {
        $this->clear();
    }

    function it_should_throw_an_exception_if_task_not_found()
    {
        $taskId = TaskId::createFromString(self::UUID);

        $this->shouldThrow(TaskNotFoundException::CLASS)->during('findByTaskId', [$taskId]);
    }

    function it_should_find_a_task_by_id()
    {
        $taskId = TaskId::createFromString(self::UUID);

        $this->add($this->task);

        $this->findByTaskId($taskId)->shouldReturn($this->task);
    }

    function it_should_add_a_task()
    {
        $this->add($this->task);

        $this->findByTaskId($this->task->getId())->shouldReturn($this->task);
    }
}
