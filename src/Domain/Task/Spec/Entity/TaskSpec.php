<?php

namespace Spec\Domain\Task\Entity;

use Domain\Core\Exception\AssertionFailedException;
use Domain\Core\Spec\TestValues;
use Domain\Core\ValueObject\Description;
use Domain\Task\Entity\Task;
use Domain\Task\ValueObject\Estimated;
use Domain\Task\ValueObject\TaskId;
use Domain\Task\ValueObject\TaskName;
use Domain\Task\ValueObject\TimeSpent;
use Domain\User\Entity\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TaskSpec extends ObjectBehavior
{
    function let(User $user)
    {
        $this->beConstructedWith(
            TaskId::createFromString(TestValues::UUID),
            $user,
            new TaskName(TestValues::TASK_NAME),
            new \DateTime(TestValues::DATE)
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

    function it_should_set_its_name()
    {
        $name = new TaskName(TestValues::TASK_NAME2);

        $this->setName($name);

        $this->getName()->shouldReturn($name);
    }

    function it_should_returns_its_description()
    {
        $this->getDescription()->shouldHaveType(Description::CLASS);
    }

    function it_should_return_description_which_was_set()
    {
        $description = new Description(TestValues::DESCRIPTION);

        $this->setDescription($description);

        $this->getDescription()->shouldReturn($description);
    }

    function it_should_returns_its_date()
    {
        $this->getDate()->shouldHaveType(\DateTime::CLASS);
    }

    function it_should_set_its_date()
    {
        $date = new \DateTime(TestValues::DATE2);

        $this->setDate($date);

        $this->getDate()->shouldReturn($date);
    }

    function it_should_return_its_estimated()
    {
        $this->getEstimated()->shouldHaveType(Estimated::CLASS);
    }

    function it_should_return_estimated_which_was_set()
    {
        $estimated = new Estimated(TestValues::ESTIMATED);

        $this->setEstimated($estimated);

        $this->getEstimated()->shouldReturn($estimated);
    }

    function it_should_return_completed_at_when_its_not_completed()
    {
        $this->getCompletedAt()->shouldReturn(null);
    }

    function it_should_return_completed_at_when_its_set_as_not_completed()
    {
        $this->setCompletedAt(null);

        $this->getCompletedAt()->shouldReturn(null);
    }

    function it_should_return_completed_at_when_its_completed()
    {
        $date = new \DateTime(TestValues::COMPLETED_DATE);

        $this->setCompletedAt($date);

        $this->getCompletedAt()->shouldReturn($date);
    }

    function it_should_not_be_completed()
    {
        $this->shouldNotBeCompleted();
    }

    function it_should_be_completed()
    {
        $date = new \DateTime(TestValues::COMPLETED_DATE);

        $this->setCompletedAt($date);

        $this->shouldBeCompleted();
    }

    function it_should_return_its_time_spent()
    {
        $this->getTimeSpent()->shouldHaveType(TimeSpent::CLASS);
    }

    function it_should_return_time_spent_which_was_set()
    {
        $timeSpent = new TimeSpent(TestValues::TIME_SPENT);

        $this->setTimeSpent($timeSpent);

        $this->getTimeSpent()->shouldReturn($timeSpent);
    }

    function it_should_be_important_by_default()
    {
        $this->shouldBeImportant();
    }

    function it_should_set_important()
    {
        $this->setImportant(TestValues::NOT_IMPORTANT);

        $this->shouldNotBeImportant();
    }

    function it_should_return_its_created_at()
    {
        $this->getCreatedAt()->shouldHaveType(\DateTime::CLASS);
    }

    function it_should_throw_an_exception_if_important_value_is_not_boolean()
    {
        $this
            ->shouldThrow(AssertionFailedException::CLASS)
            ->during('setImportant', [1])
        ;
    }
}
