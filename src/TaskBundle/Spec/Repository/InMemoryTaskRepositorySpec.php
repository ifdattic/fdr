<?php

namespace Spec\TaskBundle\Repository;

use Domain\Core\Spec\TestValues;
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
    /** @var Task */
    private $task;

    /** @var User */
    private $user;

    function let()
    {
        $this->user = new User(
            UserId::createFromString(TestValues::UUID),
            new Email(TestValues::EMAIL),
            new FullName(TestValues::FULLNAME),
            new PasswordHash(TestValues::PASSWORD_HASH)
        );

        $this->task = new Task(
            TaskId::createFromString(TestValues::UUID),
            $this->user,
            new TaskName(TestValues::TASK_NAME),
            new \DateTime(TestValues::DATE)
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
        $taskId = TaskId::createFromString(TestValues::UUID);

        $this->shouldThrow(TaskNotFoundException::CLASS)->during('findByTaskId', [$taskId]);
    }

    function it_should_find_a_task_by_id()
    {
        $taskId = TaskId::createFromString(TestValues::UUID);

        $this->add($this->task);

        $this->findByTaskId($taskId)->shouldReturn($this->task);
    }

    function it_should_add_a_task()
    {
        $this->add($this->task);

        $this->findByTaskId($this->task->getId())->shouldReturn($this->task);
    }

    function it_should_return_empty_array_if_user_has_no_tasks()
    {
        $this->findAllByUser($this->user)->shouldReturn([]);
    }

    function it_should_return_all_users_tasks(User $user2, Task $task1, Task $task2)
    {
        $expectedTasks = [$this->task, $task2];

        $task1->getUser()->shouldBeCalled()->willReturn($user2);
        $task2->getUser()->shouldBeCalled()->willReturn($this->user);

        $this->add($this->task);
        $this->add($task1);
        $this->add($task2);

        $this->findAllByUser($this->user)->shouldReturn($expectedTasks);
    }

    function it_should_throw_an_exception_if_task_is_not_found_when_removing()
    {
        $taskId = TaskId::createFromString(TestValues::UUID);

        $this
            ->shouldThrow(TaskNotFoundException::CLASS)
            ->during('removeByTaskId', [$taskId])
        ;
    }

    function it_should_remove_a_task_by_id(Task $task1, Task $task2, Task $task3)
    {
        $taskId = TaskId::createFromString(TestValues::UUID2);
        $task1->getId()->shouldBeCalled()->willReturn(TaskId::createFromString(TestValues::UUID));
        $task2->getId()->shouldBeCalled()->willReturn(TaskId::createFromString(TestValues::UUID2));
        $task3->getId()->shouldBeCalled()->willReturn(TaskId::createFromString(TestValues::UUID3));

        $this->add($task1);
        $this->add($task2);
        $this->add($task3);

        $this->removeByTaskId($taskId);

        $this
            ->shouldThrow(TaskNotFoundException::CLASS)
            ->during('findByTaskId', [$taskId])
        ;
    }

    function it_should_throw_an_exception_when_updating_if_task_not_found(Task $task)
    {
        $taskId = TaskId::createFromString(TestValues::UUID2);

        $this
            ->shouldThrow(TaskNotFoundException::CLASS)
            ->during('save', [$task])
        ;
    }

    function it_should_save_updated_task(Task $task1, Task $task2, Task $task3, Task $task2Updated)
    {
        $taskId = TaskId::createFromString(TestValues::UUID2);
        $task1->getId()->shouldBeCalled()->willReturn(TaskId::createFromString(TestValues::UUID));
        $task2->getId()->shouldBeCalled()->willReturn(TaskId::createFromString(TestValues::UUID2));
        $task3->getId()->shouldNotBeCalled();
        $task2Updated->getId()->shouldBeCalled()->willReturn(TaskId::createFromString(TestValues::UUID2));

        $this->add($task1);
        $this->add($task2);
        $this->add($task3);

        $this->save($task2Updated);

        $this->findByTaskId($taskId)->shouldReturn($task2Updated);
    }
}
