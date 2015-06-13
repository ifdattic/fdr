<?php

namespace Spec\Domain\Task\Command;

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
    const COMPLETED_DATE = '2015-04-15 13:14:15';
    const DATE           = '2015-04-15';
    const DESCRIPTION    = 'This is the description.';
    const ESTIMATED      = 3;
    const IMPORTANT      = false;
    const TASK_NAME      = 'Task Name';
    const TIME_SPENT     = 23;

    function let(User $user)
    {
        $this->beConstructedWith(
            $user,
            self::TASK_NAME,
            self::DATE,
            self::DESCRIPTION,
            self::ESTIMATED,
            self::COMPLETED_DATE,
            self::TIME_SPENT,
            self::IMPORTANT
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
        $this->getName()->shouldBeLike(new TaskName(self::TASK_NAME));
    }

    function it_should_returns_its_date()
    {
        $this->getDate()->shouldBeLike(new \DateTime(self::DATE));
    }

    function it_should_returns_its_description()
    {
        $this->getDescription()->shouldBeLike(new Description(self::DESCRIPTION));
    }

    function it_should_return_its_estimated()
    {
        $this->getEstimated()->shouldBeLike(new Estimated(self::ESTIMATED));
    }

    function it_should_return_its_completed_at()
    {
        $this->getCompletedAt()->shouldBeLike(new \DateTime(self::COMPLETED_DATE));
    }

    function it_should_return_its_time_spent()
    {
        $this->getTimeSpent()->shouldBeLike(new TimeSpent(self::TIME_SPENT));
    }

    function it_should_return_its_important()
    {
        $this->getImportant()->shouldReturn(self::IMPORTANT);
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
