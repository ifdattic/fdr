<?php

namespace Spec\Domain\Task\Command;

use Domain\Core\ValueObject\Description;
use Domain\Task\Command\CreateTask;
use Domain\Task\ValueObject\Done;
use Domain\Task\ValueObject\Estimated;
use Domain\Task\ValueObject\TaskName;
use Domain\Task\ValueObject\TimeSpent;
use Domain\User\Entity\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CreateTaskSpec extends ObjectBehavior
{
    const DATE        = '2015-04-15';
    const DESCRIPTION = 'This is the description.';
    const DONE        = true;
    const ESTIMATED   = 3;
    const TASK_NAME   = 'Task Name';
    const TIME_SPENT  = 23;

    function let(User $user)
    {
        $this->beConstructedWith(
            $user,
            self::TASK_NAME,
            self::DATE,
            self::DESCRIPTION,
            self::ESTIMATED,
            self::DONE,
            self::TIME_SPENT
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
        $this->getDate()->shouldBeLike(new \DateTimeImmutable(self::DATE));
    }

    function it_should_returns_its_description()
    {
        $this->getDescription()->shouldBeLike(new Description(self::DESCRIPTION));
    }

    function it_should_return_its_estimated()
    {
        $this->getEstimated()->shouldBeLike(new Estimated(self::ESTIMATED));
    }

    function it_should_return_its_done()
    {
        $this->getDone()->shouldBeLike(new Done(self::DONE));
    }

    function it_should_return_its_time_spent()
    {
        $this->getTimeSpent()->shouldBeLike(new TimeSpent(self::TIME_SPENT));
    }
}
