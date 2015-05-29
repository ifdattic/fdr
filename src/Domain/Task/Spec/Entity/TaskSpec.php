<?php

namespace Spec\Domain\Task\Entity;

use Domain\Core\ValueObject\Description;
use Domain\Task\Entity\Task;
use Domain\Task\ValueObject\Done;
use Domain\Task\ValueObject\Estimated;
use Domain\Task\ValueObject\TaskId;
use Domain\Task\ValueObject\TaskName;
use Domain\Task\ValueObject\TimeSpent;
use Domain\User\Entity\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TaskSpec extends ObjectBehavior
{
    const DATE        = '2015-04-15';
    const DESCRIPTION = 'This is the description.';
    const DONE        = true;
    const ESTIMATED   = 3;
    const TASK_NAME   = 'Task Name';
    const TIME_SPENT  = 23;
    const UUID        = '5399dbab-ccd0-493c-be1a-67300de1671f';

    function let(User $user)
    {
        $this->beConstructedWith(
            TaskId::createFromString(self::UUID),
            $user,
            new TaskName(self::TASK_NAME),
            new \DateTimeImmutable(self::DATE)
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Task::CLASS);
    }

    function it_should_return_its_id()
    {
        $this->getId()->shouldHaveType(TaskId::CLASS);
    }

    function it_should_return_its_user()
    {
        $this->getUser()->shouldHaveType(User::CLASS);
    }

    function it_should_return_its_name()
    {
        $this->getName()->shouldHaveType(TaskName::CLASS);
    }

    function it_should_returns_its_description()
    {
        $this->getDescription()->shouldHaveType(Description::CLASS);
    }

    function it_should_return_description_which_was_set()
    {
        $description = new Description(self::DESCRIPTION);

        $this->setDescription($description);

        $this->getDescription()->shouldReturn($description);
    }

    function it_should_returns_its_date()
    {
        $this->getDate()->shouldHaveType(\DateTimeImmutable::CLASS);
    }

    function it_should_return_its_estimated()
    {
        $this->getEstimated()->shouldHaveType(Estimated::CLASS);
    }

    function it_should_return_estimated_which_was_set()
    {
        $estimated = new Estimated(self::ESTIMATED);

        $this->setEstimated($estimated);

        $this->getEstimated()->shouldReturn($estimated);
    }

    function it_should_return_its_done()
    {
        $this->getDone()->shouldHaveType(Done::CLASS);
    }

    function it_should_return_its_done_as_boolean_value()
    {
        $this->shouldNotBeDone();
    }

    function it_should_return_done_which_was_set()
    {
        $done = new Done(self::DONE);

        $this->setDone($done);

        $this->getDone()->shouldReturn($done);
        $this->shouldBeDone();
    }

    function it_should_returns_its_time_spent()
    {
        $this->getTimeSpent()->shouldHaveType(TimeSpent::CLASS);
    }

    function it_should_returns_time_spent_which_was_set()
    {
        $timeSpent = new TimeSpent(self::TIME_SPENT);

        $this->setTimeSpent($timeSpent);

        $this->getTimeSpent()->shouldReturn($timeSpent);
    }
}
