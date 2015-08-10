<?php

namespace Spec\Domain\Task\Command;

use Domain\Core\Spec\TestValues;
use Domain\Core\ValueObject\Description;
use Domain\Task\Command\CreateTask;
use Domain\Task\Entity\Task;
use Domain\Task\ValueObject\Estimated;
use Domain\Task\ValueObject\TaskName;
use Domain\Task\ValueObject\TimeSpent;
use Domain\User\Entity\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CreateTaskSpec extends ObjectBehavior
{
    function let(User $user)
    {
        $this->beConstructedWith(
            $user,
            TestValues::TASK_NAME,
            TestValues::DATE,
            TestValues::DESCRIPTION,
            TestValues::ESTIMATED,
            TestValues::COMPLETED_DATE,
            TestValues::TIME_SPENT,
            TestValues::NOT_IMPORTANT
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CreateTask::CLASS);
    }

    function it_should_returns_its_user(User $user)
    {
        $this->getUser()->shouldReturn($user);
    }

    function it_should_returns_its_name()
    {
        $this->getName()->shouldBeLike(new TaskName(TestValues::TASK_NAME));
    }

    function it_should_returns_its_date()
    {
        $this->getDate()->shouldBeLike(new \DateTime(TestValues::DATE));
    }

    function it_should_returns_its_description()
    {
        $this->getDescription()->shouldBeLike(new Description(TestValues::DESCRIPTION));
    }

    function it_should_return_its_estimated()
    {
        $this->getEstimated()->shouldBeLike(new Estimated(TestValues::ESTIMATED));
    }

    function it_should_return_its_completed_at()
    {
        $this->getCompletedAt()->shouldBeLike(new \DateTime(TestValues::COMPLETED_DATE));
    }

    function it_should_return_its_time_spent()
    {
        $this->getTimeSpent()->shouldBeLike(new TimeSpent(TestValues::TIME_SPENT));
    }

    function it_should_return_its_important()
    {
        $this->getImportant()->shouldReturn(TestValues::NOT_IMPORTANT);
    }

    function it_should_throw_an_exception_if_returning_task_without_setting_it()
    {
        $this
            ->shouldThrow(\RuntimeException::CLASS)
            ->during('getTask')
        ;
    }

    function it_should_return_a_task_which_was_set(Task $task)
    {
        $this->setTask($task);

        $this->getTask()->shouldReturn($task);
    }
}
