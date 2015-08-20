<?php

namespace Spec\Domain\Task\Entity;

use Domain\Core\Exception\AssertionFailed;
use Domain\Core\Spec\TestValues;
use Domain\Core\ValueObject\Description;
use Domain\Task\Entity\Task;
use Domain\Task\ValueObject\Estimate;
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

    function it_should_update_its_name()
    {
        $name = new TaskName(TestValues::TASK_NAME2);

        $this->updateName($name);

        $this->getName()->shouldReturn($name);
    }

    function it_should_returns_its_description()
    {
        $this->getDescription()->shouldHaveType(Description::CLASS);
    }

    function it_should_return_updated_description()
    {
        $description = new Description(TestValues::DESCRIPTION);

        $this->updateDescription($description);

        $this->getDescription()->shouldReturn($description);
    }

    function it_should_returns_its_date()
    {
        $this->getDate()->shouldHaveType(\DateTime::CLASS);
    }

    function it_should_update_its_date()
    {
        $date = new \DateTime(TestValues::DATE2);

        $this->updateDate($date);

        $this->getDate()->shouldReturn($date);
    }

    function it_should_return_its_estimate()
    {
        $this->getEstimate()->shouldHaveType(Estimate::CLASS);
    }

    function it_should_return_initial_estimate_which_was_set()
    {
        $estimate = new Estimate(TestValues::ESTIMATE);

        $this->setInitialEstimate($estimate);

        $this->getEstimate()->shouldReturn($estimate);
    }

    function it_should_return_adjusted_estimate()
    {
        $estimate = new Estimate(TestValues::ESTIMATE);

        $this->adjustEstimate($estimate);

        $this->getEstimate()->shouldReturn($estimate);
    }

    function it_should_return_completed_at_when_its_not_completed()
    {
        $this->getCompletedAt()->shouldReturn(null);
    }

    function it_should_return_completed_at_when_its_marked_as_incomplete()
    {
        $this->markAsIncomplete();

        $this->getCompletedAt()->shouldReturn(null);
    }

    function it_should_return_completed_at_when_its_completed()
    {
        $date = new \DateTime(TestValues::COMPLETED_DATE);

        $this->complete($date);

        $this->getCompletedAt()->shouldReturn($date);
    }

    function it_should_not_be_completed()
    {
        $this->shouldNotBeCompleted();
    }

    function it_should_be_completed()
    {
        $date = new \DateTime(TestValues::COMPLETED_DATE);

        $this->complete($date);

        $this->shouldBeCompleted();
    }

    function it_should_return_its_time_spent()
    {
        $this->getTimeSpent()->shouldHaveType(TimeSpent::CLASS);
    }

    function it_should_return_initial_time_spent_which_was_set()
    {
        $timeSpent = new TimeSpent(TestValues::TIME_SPENT);

        $this->setInitialTimeSpent($timeSpent);

        $this->getTimeSpent()->shouldReturn($timeSpent);
    }

    function it_should_return_adjusted_time_spent()
    {
        $timeSpent = new TimeSpent(TestValues::TIME_SPENT);

        $this->adjustTimeSpent($timeSpent);

        $this->getTimeSpent()->shouldReturn($timeSpent);
    }

    function it_should_be_important_by_default()
    {
        $this->shouldBeImportant();
    }

    function it_should_mark_as_not_important()
    {
        $this->markAsNotImportant();

        $this->shouldNotBeImportant();
    }

    function it_should_return_its_created_at()
    {
        $this->getCreatedAt()->shouldHaveType(\DateTime::CLASS);
    }
}
